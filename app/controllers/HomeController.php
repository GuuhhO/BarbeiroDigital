<?php

require_once __DIR__ . '/../models/AdminModel.php';

class HomeController
{
   public function index()
   {
      $modelo = new AdminModel();

      $servicos = $modelo->obterServicos();
      view('home/index', ['servicos' => $servicos]);
   }

   public function sobre() {
      view('home/sobre');
   }
}
