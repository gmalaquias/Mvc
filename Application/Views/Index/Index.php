<form action="" method="post" enctype="multipart/form-data">
    <?php
    use Mvc\Html;
    Html::ValidateSummary();

    Html::text('Nome',$model->Nome);
    Html::text('Email',$model->Email);

    ?>





    <?php  Html::checkBox("Apagado",$model->Apagado); ?>

    <?php  Html::checkBox("TipoPessoaFisica",$model->TipoPessoaFisica); ?>








    <br/>
    <br/>


    <input type="submit"/>
</form>





