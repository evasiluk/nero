<?php
/**
 * Created by PhpStorm.
 * User: Magestro
 * Date: 023 23.04.18
 * Time: 14:49
 */

namespace Astronim;
use Bitrix\Main\Loader;


class FaqVoteAction
{
    const SESSION_INDICATOR = 'faq_vote_llknkbhvsuyglbsbhfdbgjkn';
    const ACTION_PLUS = 'plus';
    const ACTION_MINUS = 'minus';
    const PROPERTY_RATING_PLUS = 'rating_plus';
    const PROPERTY_RATING_MINUS = 'rating_minus';


    private $iblock_id;


    public function __construct($iblock_id)
    {
        Loader::includeModule('iblock');
        $this->iblock_id = (int)$iblock_id;
    }

    function isValidId($id)
    {
        return \Bitrix\Iblock\ElementTable::getRow(['filter' => ['IBLOCK_ID' => $this->iblock_id, 'ID' => $id]]);
    }

    function isValidAction($action)
    {
        return in_array($action, [self::ACTION_PLUS, self::ACTION_MINUS]);
    }

    function getUserLastVote($element_id)
    {
        return $_SESSION[self::SESSION_INDICATOR][$element_id];
    }

    function setUserLastVote($element_id, $vote)
    {
        $_SESSION[self::SESSION_INDICATOR][$element_id] = $vote;
    }

    function getCodeByAction($action)
    {
        switch ($action) {
            case self::ACTION_MINUS:
                $code = self::PROPERTY_RATING_MINUS;
                break;
            case self::ACTION_PLUS:
            default: //todo rework this shit
                $code = self::PROPERTY_RATING_PLUS;
                break;
        }

        return $code;
    }

    function getRating($id, $action)
    {
        $property_code = $this->getCodeByAction($action);
        return (int) \CIBlockElement::GetProperty($this->iblock_id, $id, [], ['CODE' => $property_code])->GetNext()['VALUE'];
    }

    function setRating($id, $action, $rating)
    {
        $property_code = $this->getCodeByAction($action);
        \CIBlockElement::SetPropertyValuesEx($id, $this->iblock_id, [$property_code => $rating]);
    }

    function incrementRating($id, $action)
    {
        $property_code = $this->getCodeByAction($action);
        $rating = $this->getRating($id, $property_code);
        $rating++;
        $this->setRating($id, $property_code, $rating);
    }

    function decrementRating($id, $action)
    {
        $property_code = $this->getCodeByAction($action);
        $rating = $this->getRating($id, $property_code);
        $rating--;
        $this->setRating($id, $property_code, $rating);
    }
}