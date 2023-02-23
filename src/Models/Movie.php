<?php

namespace BlockBuster\app;

class Movie extends Model{
    
    public function __construct($movie ) {
        
        foreach ( $movie as $key => $value) {
            
            $this->$key = $value;
        }
    }
}
