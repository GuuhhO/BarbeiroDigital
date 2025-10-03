<?php

class Util
{
    public static function modalError($titulo, $conteudo, $id = null)
    {
        if (!$id) {
            $id = 'modal_' . uniqid();
        }

        $modal = <<<HTML
        <div class="modal fade" tabindex="-1" id="{$id}" aria-hidden="true" aria-labelledby="{$id}Label">
            <div class="modal-dialog modal-dialog-centered m-auto d-flex justify-content-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{$id}Label">{$titulo}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        {$conteudo}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('{$id}'));
                myModal.show();
            });
        </script>
        HTML;

        return $modal;
    }
}

