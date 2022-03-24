<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= APLICACAO_NOME ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= URL_CSS . 'style.css'?>">
    </head>
    <body>
        <header>
            <a class="nome-site" href="<?= URL_RAIZ . 'laboratorio' ?>">Sistema para a Reserva de laboratórios</a>
            <?php if ($usuario != null) : ?>
                <div class="sair-conta">
                    <form action="<?= URL_RAIZ . 'login' ?>" method="post">
                        <input type="hidden" name="_metodo" value="DELETE">
                        <a class="sair-conta-link" href="" onclick="event.preventDefault(); this.parentNode.submit()">
                            Sair da Conta
                        </a>
                    </form>
                </div>
            <?php endif ?>
        </header>
        <main>
            <?php $this->imprimirConteudo() ?>
        </main>
        <footer>
            <a  class="nome-site" href="<?= URL_RAIZ . 'laboratorio' ?>">Sistema para a Reserva de laboratórios</a>
        </footer>
    </body>
</html>