const api = {
    util: {
        ajax: function (metodo, url, dados, sucesso, erro) {
            $.ajax({
                type: metodo,
                url: url,
                data: dados,
                success: sucesso,
                error: erro
            });
        }
    }
};
