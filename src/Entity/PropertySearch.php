<?php

namespace App\Entity;

class PropertySearch
{
    private $title;

    // private $collection;

    // private $editeur;

    public function setTitle($title) : self
    {
        $this->title = $title;
        return $this;
     }

    //  public function setCollection($collection) : self
    //  {
    //      $this->collection = $collection;
    //      return $this;
    //   }

    //   public function setEditeur($editeur) : self
    //   {
    //       $this->editeur = $editeur;
    //       return $this;
    //    }

       public function  getTitle()
       {
           return $this->title;
        }
        // public function  getEditeur()
        // {
        //     return $this->editeur;
        //  }
        //  public function  getCollection()
        //  {
        //      return $this->collection;
        //   }
}
