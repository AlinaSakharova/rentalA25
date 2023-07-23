<?php
require_once 'backend/sdbh.php';
$dbh = new sdbh();
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="assets/css/style.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="assets/css/style_form.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <style>
            #container_form {
                margin-top: 50px;
                border-radius: 15px;
                border: 3px solid #333;
            }
            .col-3{
                background-color: #FF9A00;
                border-radius: 0;
                border-top-left-radius: 13px;
                border-bottom-left-radius: 13px;
                display: flex;
                align-items: center;
                flex-flow: column;
                justify-content: center;
                font-size: 26px;
                font-weight: 900;
            }
            label:not([class="form-check-label"]) {
                font-size: 16px;
                font-weight: 600;
            }
            .form-check-input:checked{
                background-color: #FF9A00;
                border-color: #FF9A00;
            }
            .col-9{
                padding: 25px;
            }
            .btn-primary {
                color: #fff;
                background-color: #FF9A00;
                border-color: #FF9A00;
            }
            #form_answer{
                font-size: 20px;
                font-weight: 600;

            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row row-header">
                <div class="col-12">
                    <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
                    <h1>Прокат</h1>
                </div>
            </div>
            <!-- TODO: реализовать форму расчета -->
             <div class="row row-form">
                <div class="col-12">
                    <div class="container" id="container_form">
                        <div class="row row-body">
                            <div class="col-3">
                                <span style="text-align: center">Форма расчета</span>
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="col-9">
                                <form action="" id="form" method="post">

                                    <label class="form-label" for="product">Выберите продукт:</label>

                                    <?$products = $dbh->mselect_cols('a25_products', 'ID','NAME', 'PRICE', 'TARIFF', 'id');?>
                                    <select class="form-select" name="product" id="product">
                                        <?foreach ($products as $p){
                                            echo "<option value=".$p['ID'].">".$p['NAME']." за ".$p['PRICE']."</option> ";
                                        }?>
                                    </select>

                                    <label for="customRange1" class="form-label">Количество дней:</label>
                                    <input type="text" name="days" class="form-control" id="customRange1" min="1" max="30">

                                    <label for="customRange1" class="form-label">Дополнительно:</label>
                                    <?$services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);?>
                                    <?foreach($services as $k => $s) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" name="services[]" type="checkbox" value="<?=$s?>" id="flexCheckChecked" checked>
                                        <label class="form-check-label"  for="flexCheckChecked">
                                            <?=$k?>: <?=$s?>
                                        </label>
                                    </div>
                                    <?}?>
                                    <button type="submit" name="submit" class="btn btn-primary">Рассчитать</button>
                                    <div id="form_answer"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="assets/js/script.js"></script>