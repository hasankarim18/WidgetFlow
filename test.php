<?php


interface Module
{
    /**
     * Attach this module's hooks to WordPress.
     */
    public function register(): void;
}


class Notice implements Module
{

    public function register(): void
    {
        // -------------- do some action
    }

}


Notice::class;