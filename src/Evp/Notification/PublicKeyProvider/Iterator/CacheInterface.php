<?php

interface Evp_Notification_PublicKeyProvider_Iterator_CacheInterface
{

    public function has();

    public function get();

    public function set($value);

}