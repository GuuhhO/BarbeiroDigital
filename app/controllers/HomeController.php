<?php

class HomeController
{
   public function index() {
      view('home/index');
   }

   public function sobre() {
      view('home/sobre');
   }
}
