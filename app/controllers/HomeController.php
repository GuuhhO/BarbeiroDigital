<?php

require_once __DIR__ . '/../models/ServicoModel.php';

class HomeController
{
   public function index()
   {
      $modelo = new ServicoModel();

      $servicos = $modelo->obterServicosAtivos();
      view('home/index', ['servicos' => $servicos]);
   }

   public function sobre() {
      view('home/sobre');
   }
}
