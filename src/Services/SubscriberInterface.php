<?php

namespace EmailMarketing\Services;

interface SubscriberInterface
{
    public function subscribe();

    public function unsubscribe();
}