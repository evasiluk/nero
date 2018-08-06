<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$iblock_id = 18;
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$result = [];

$helper = new \Astronim\FaqVoteAction($iblock_id);
if (($id = (int)$request->get('id'))
    && $helper->isValidId($id)
    && ($action = $request->get('action'))
    && $helper->isValidAction($action)
) {
    $last_vote = $helper->getUserLastVote($id);

    if ($last_vote && ($last_vote != $action)) {
        $helper->decrementRating($id, $last_vote);
        $helper->incrementRating($id, $action);
        $helper->setUserLastVote($id, $action);

        $result['result'] = true;
        $result['text'] = 'Ваш голос изменён!';
    } elseif (!$last_vote) {
        $helper->incrementRating($id, $action);
        $helper->setUserLastVote($id, $action);

        $result['result'] = true;
        $result['text'] = 'Спасибо за ваш голос!';
    } else {
        $result['result'] = false;
        $result['text'] = 'Вы уже проголосовали за этот вопрос';
    }

} else {
    $result['result'] = false;
    $result['text'] = 'Неверный запрос';
}

//in this case can be reworked
echo json_encode($result, JSON_UNESCAPED_UNICODE);

