<?php

namespace App\Console\Commands;

use App\Book;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class FetchBooks
 * @package App\Console\Commands
 */
class FetchBooks extends Command
{
    /**
     * @var string $apiUrl
     */
    private $apiUrl = 'https://api.nytimes.com/svc/books/v3/';

    /**
     * @var int $apiRateLimit
     */
    private $apiRateLimit = 6;

    /**
     * @var array $apiBookAttributes
     */
    private $apiBookAttributes = [
        'title',
        'author',
        'primary_isbn10',
        'primary_isbn13',
        'book_image'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_books {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch new books';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        // Create a Guzzle Glient to make the external API requests
        $client = new Client();

        // First request to gather all list names
        if ($this->option('dev')) {
            $listSlugs = ['hardcover-nonfiction'];
        } else {
            $listSlugs = $this->fetchListSlugs($client, $this->buildApiUrl('lists/names.json'));
        }


        // Setup progress bar
        $bar = $this->output->createProgressBar(count($listSlugs));
        $bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
        $bar->start();

        // Loop through lists to populate books
        foreach ($listSlugs as $listSlug) {
            $bar->setMessage('Importing List: ' . $listSlug);
            $this->attemptApiRequest($client, $bar, $listSlug);
        }
    }

    /**
     * Attempt external API request
     *
     * @param Client $client
     * @param ProgressBar $bar
     * @param string $listSlug
     */
    private function attemptApiRequest(Client $client, ProgressBar $bar, string $listSlug)
    {
        // Perform API request
        $bookData = $this->gatherBookDataFromRequest($client, $this->buildApiUrl('lists/current/' . $listSlug));

        // Generate books
        $this->generateBooksFromData($bookData);

        // Advance progress bar
        $bar->advance();

        // Sleep duration specified by NYT API docs to avoid rate limits
        if (!$this->option('dev')) {
            sleep($this->apiRateLimit);
        }
    }

    /**
     * Helper method to generate API urls for NYT
     *
     * @param string $endpoint
     * @return string
     */
    private function buildApiUrl(string $endpoint)
    {
        return $this->apiUrl . $endpoint . '?api-key=' . env('NYT_API_KEY');
    }

    /**
     * Method to gather encoded list names for NYT list retrieval
     *
     * @param Client $client
     * @param string $url
     * @return array
     */
    private function fetchListSlugs(Client $client, string $url): array
    {
        $response = $client->request('GET', $url);

        $lists = json_decode($response->getBody()->getContents(), true);

        return array_column($lists['results'], 'list_name_encoded');
    }

    /**
     * Gather raw book data from API request
     *
     * @param Client $client
     * @param string $url
     * @return array
     */
    private function gatherBookDataFromRequest(Client $client, string $url): array
    {
        $response = $client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true)['results']['books'];
    }

    /**
     * Generate book models from book data set ISBNs if present
     *
     * @param array $bookData
     */
    private function generateBooksFromData(array $bookData)
    {
        array_walk($bookData, function (array $book) {
            $bookAttributes = collect($book)->only($this->apiBookAttributes)->toArray();

            Book::firstOrCreate($bookAttributes);
        });
    }
}
