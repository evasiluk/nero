<?php
/**
 * Created by PhpStorm.
 * User: Magestro
 * Date: 024 24.04.18
 * Time: 19:23
 */

namespace Astronim;


use Snscripts\HtmlHelper\Html;
use Snscripts\HtmlHelper\Helpers;
use Snscripts\HtmlHelper\Services;

class RegisterTemplateHtml extends Html
{
    private $arParams;
    private $arResult;

    function __construct($arParams, $arResult)
    {
        $this->arParams = $arParams;
        $this->arResult = $arResult;

        parent::__construct(
            new Helpers\Form(
                new Services\Basic\Data
            ),
            new Services\Basic\Router,
            new Services\Basic\Assets
        );
    }

    public function text($key, $label, $attr = [])
    {
        $note = '';
        if (is_array($label)) {
            list($label, $note) = $label;

            if(!$attr['placeholder'])
                $attr['placeholder'] = '';
        }
        $attr = $this->prepareAttr($key, $attr);
        if ($attr['required']) $label .= '<sup>*</sup>';

        $this->printTextHtml($label, $note, $this->Form->input(
        // translates to $_POST['REGISTER'][$key']
            'REGISTER.' . $key,
            false,
            $attr
        ));
    }

    public function text_uf($key, $label, $attr = [])
    {
        $note = '';
        if (is_array($label)) {
            list($label, $note) = $label;

            if(!$attr['placeholder'])
                $attr['placeholder'] = '';
        }
        $attr = $this->prepareAttr($key, $attr);
        if ($attr['required']) $label .= '<sup>*</sup>';

        $this->printTextHtml($label, $note, $this->Form->input(
        // translates to $_POST['REGISTER'][$key']
            $key,
            false,
            $attr
        ));
    }

    public function select($key, $label, $options, $attr = [])
    {
        $note = '';
        if (is_array($label)) {
            list($label, $note) = $label;
        }

        $attr = $this->prepareAttr($key, $attr);
        $attr['data-select'] = '';

        if ($attr['required']) $label .= '<sup>*</sup>';

        $this->printSelectHtml($label, $note, $this->Form->select(
        // translates to $_POST['REGISTER'][$key']
            'REGISTER.' . $key,
            false,
            $options,
            $attr
        ));
    }

    public function select_uf($key, $label, $options, $attr = [])
    {
        $note = '';
        if (is_array($label)) {
            list($label, $note) = $label;
        }

        $attr = $this->prepareAttr($key, $attr);
        $attr['data-select'] = '';

        if ($attr['required']) $label .= '<sup>*</sup>';

        $this->printSelectHtml($label, $note, $this->Form->select(
        // translates to $_POST['REGISTER'][$key']
            $key,
            false,
            $options,
            $attr
        ));
    }

    private function prepareAttr($key, $attr)
    {
        if ($this->isRequired($key))
            $attr['required'] = '';

        if (null !== $attr['required'])
            $attr['data-parsley-required'] = '';

        if (!$attr['value'])
            $attr['value'] = $this->arResult['VALUES'][$key];

        $attr['wrapper'] = false;

        return $attr;
    }

    private function isRequired($key)
    {
        if (strpos($key, 'UF_') === 0)
            return ($this->arResult['USER_PROPERTIES']['DATA'][$key]['MANDATORY'] == 'Y');
        else
            return in_array($key, $this->arResult['REQUIRED_FIELDS']);
    }

    private function printTextHtml($label, $note, $html)
    {

        echo "<div class=\"form-row flex-row\">
                    <label class=\"col-xs\">
                        <div class=\"input\">
                            <span class=\"input-label\">{$label}</span>
                            <div class=\"input-in\">
                                {$html}
                                <span class=\"focus-border\"></span>
                                <span class=\"input-note\">{$note}</span>
                            </div>
                        </div>
                    </label>
                </div>";
    }

    private function printSelectHtml($label, $note, $html)
    {

        echo "<div class=\"form-row flex-row\">
                    <div class=\"col-xs\">
                        <div class=\"input\">
                            <span class=\"input-label\">{$label}</span>
                            {$html}
                        </div>
                    </div>
                </div>";
    }
}