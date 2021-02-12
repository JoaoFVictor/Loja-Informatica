<?php

namespace App\Utils;

class Helpers
{
    private $menu = '';

    public function gerarSubcategoria($model, $inicio = true)
    {
        if ($inicio) {
            $arr = [];
            foreach ($model as $key) {
                $this->gerarSubcategoria($key, false);
                array_push($arr, $key);
            }
            return $arr;
        } else {
            $filho = $model->subCategoria()->get();
            if (!$filho->isEmpty()) {
                $model->filho = $filho;
                foreach ($filho as $key) {
                    $this->gerarSubcategoria($key, $inicio);
                }
            }
        }
    }

    public function gerarMenu($model, $inicio = true, $carregarFilhos = false)
    {
        if ($inicio) {
            foreach ($model as $key) {
                $this->gerarMenu($key, false);
            }
            return $this->menu;
        } else {
            if (!$carregarFilhos) {
                $filho = $model->categoria()->get();
                if (!$filho->isEmpty() && $model->carregar_filhos) {
                    $this->menu .= '
                    <li class="dropdown-item dropdown nav-item navbar-text nav-link">
                        <a class="nav-link dropdown-toggle" id="dropdown' . $model->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $model->nome . '</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown' . $model->id . '">
                    ';
                    $model->filho = $filho;
                    foreach ($filho as $key) {
                        $this->gerarMenu($key, $inicio, true);
                    }
                    $this->menu .= '
                </ul>
                </li>';
                } else {
                    $this->menu .= '<li class="dropdown-item nav-item navbar-text" href="#"><a class="nav-link">' . $model->nome . '</a> </li>';
                }
            } else {
                $filho = $model->subCategoria()->get();
                if (!$filho->isEmpty() && (is_null($model->carregar_filhos) || $model->carregar_filhos == 1)) {
                    if ($model->pai) {
                        $this->menu .= '
                    <li class="dropdown-item dropdown nav-item navbar-text nav-link">
                        <a class="nav-link dropdown-toggle" id="dropdown' . $model->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $model->nome . '</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown' . $model->id . '">
                    ';
                    }
                    $model->filho = $filho;
                    foreach ($filho as $key) {
                        $this->gerarMenu($key, $inicio, true);
                    }
                    $this->menu .= '
                </ul>
                </li>';
                } else {
                    $this->menu .= '<li class="dropdown-item nav-item navbar-text" href="#"><a class="nav-link">' . $model->nome . '</a> </li>';
                }
            }
        }
    }
}
