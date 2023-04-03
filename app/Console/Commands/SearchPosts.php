<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Blog;
use Elasticsearch;

class SearchPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search posts using name and category';

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
     * @return int
     */
    public function handle()
    {
        $blogs = Blog::with('categories')->where('status', '1');

        foreach ($blogs as $post) {
            try {
                Elasticsearch::index([
                    'id' => $post->id,
                    'index' => 'blogs',
                    'body' => [
                        'title' => $post->title
                    ]
                ]);
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $this->info("Posts were successfully indexed");
    }
}
