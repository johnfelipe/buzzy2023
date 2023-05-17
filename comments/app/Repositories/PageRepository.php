<?php

namespace App\Repositories;

use App\Page;
use App\Traits\RepositoryResponse;

class PageRepository
{
    use RepositoryResponse;

    /**
     * Get a page.
     *
     * @param int $id Comment ID
     *
     * @return $this
     */
    public function show($id)
    {
        if ($comment = Page::find($id)) {
            $response = $this->success($comment);
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Update a page.
     *
     * @param array $data
     *
     * @return $this
     */
    public function update($id, $data)
    {
        $page  = Page::find($id);

        try {
            $page = $page->update($data);
            $response = $this->success($page, __('Updated'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }


    /**
     * Store a page.
     *
     * @param array $data
     *
     * @return $this
     */
    public function store($data)
    {
        try {
            $comment = Page::create($data);
            $response = $this->success($comment, __('Created'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }

    /**
     * Destroy a page.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function destroy($id)
    {
        try {
            Page::destroy($id);
            $response = $this->success(true, __('Deleted'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }
}
