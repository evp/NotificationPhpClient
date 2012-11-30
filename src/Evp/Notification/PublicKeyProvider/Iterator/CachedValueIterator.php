<?php

/**
 * Iterator used to cache single value.
 * First element of iterator is cache value, if it is available.
 * If cache is not available, all other elements comes from inner iterator.
 * Each time element has been get from inner iterator, it is saved to the cache.
 */
class Evp_Notification_PublicKeyProvider_Iterator_CachedValueIterator implements Iterator
{
    /**
     * @var bool is current element from this iterator
     */
    protected $currentPointsToThis = true;

    /**
     * @var Iterator
     */
    protected $innerIterator;

    /**
     * @var Evp_Notification_PublicKeyProvider_Iterator_CacheInterface
     */
    protected $cache;

    /**
     * @var string
     */
    protected $key;


    public function __construct(
        Iterator $innerIterator,
        Evp_Notification_PublicKeyProvider_Iterator_CacheInterface $cache,
        $key = 'cache'
    ) {
        $this->innerIterator = $innerIterator;
        $this->cache = $cache;
        $this->key = $key;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        if ($this->currentPointsToThis) {
            return $this->cache->get();
        } else {
            $result = $this->innerIterator->current();
            $this->cache->set($result);
            return $result;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        if ($this->currentPointsToThis) {
            $this->currentPointsToThis = false;
            $this->innerIterator->rewind();
        } else {
            $this->innerIterator->next();
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        if ($this->currentPointsToThis) {
            return $this->key;
        } else {
            return $this->innerIterator->key();
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid()
    {
        if ($this->currentPointsToThis) {
            return true;
        } else {
            return $this->innerIterator->valid();
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        if ($this->cache->has()) {
            $this->currentPointsToThis = true;
        } else {
            $this->currentPointsToThis = false;
            $this->innerIterator->rewind();
        }
    }


}