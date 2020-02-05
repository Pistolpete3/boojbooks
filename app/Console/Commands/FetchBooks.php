<?php

namespace App\Console\Commands;

use App\Book;
use App\ReadingList;
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
    protected $signature = 'fetch-books {--dev}';

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
            $lists = [
                'list_name_encoded' => 'hardcover-nonfiction',
                'display_name' => 'Hardcover Nonfiction',
            ];
        } else {
            $lists = $this->fetchLists($client, $this->buildApiUrl('lists/names.json'));
        }

        // Setup progress bar
        $bar = $this->output->createProgressBar(count($lists));
        $bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
        $bar->start();

        // Loop through lists to populate books
        foreach ($lists as $index => $list) {
            $bar->setMessage('Importing List: ' . $list['display_name']);
            $this->attemptApiRequest($client, $bar, $list, $index);
        }
    }

    /**
     * Attempt external API request
     *
     * @param Client $client
     * @param ProgressBar $bar
     * @param array $list
     * @param int $index
     */
    private function attemptApiRequest(Client $client, ProgressBar $bar, array $list, int $index)
    {
        // Create sample Lists
        if ($index < 6) {
            $readingList = ReadingList::firstOrCreate(['name' => $list['display_name']]);
        } else {
            $readingList = null;
        }

        // Generate URL
        $url = $this->buildApiUrl('lists/current/' . $list['list_name_encoded']);

        // Perform API request
        $bookData = $this->gatherBookDataFromRequest($client, $url, $readingList);

        // Generate books
        $this->generateBooksFromData($bookData, $readingList);

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
    private function fetchLists(Client $client, string $url): array
    {
        $response = $client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true)['results'];
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
     * Generate book models from book data
     *
     * @param array $bookData
     * @param ReadingList $readingList
     */
    private function generateBooksFromData(array $bookData, ReadingList $readingList = null)
    {
        array_walk($bookData, function (array $book) use ($readingList) {
            $bookAttributes = collect($book)->only($this->apiBookAttributes)->toArray();

            // Create the book
            $book = Book::firstOrCreate($bookAttributes);

            // Attach the book to the reading list if present
            if ($readingList) {
                $readingList->books()->attach($book);
            }
        });
    }
}
