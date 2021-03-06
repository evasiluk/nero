<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

if ($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
	Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
}
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle("");

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach ($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}

	$component = $this->__component;

	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach ($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	?>


<br>

    <?
    $APPLICATION->SetTitle("Заказ №".htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]));
    ?>
    <form action="/managers/zakazy/order_handler.php" method="post">
    <input type="hidden" name="id" value="<?=$arResult["ID"]?>">
	<div class="container-fluid sale-order-detail">
		<div class="sale-order-detail-title-container">
			<h1 class="sale-order-detail-title-element">
				<?= Loc::getMessage('SPOD_LIST_MY_ORDER', array(
					'#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
					'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
				)) ?>
			</h1>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-general">
			<div class="row">
				<div class="col-md-12 cols-sm-12 col-xs-12 sale-order-detail-general-head">
					<span class="sale-order-detail-general-item">
						<?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array(
							"#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
							"#DATE_ORDER_CREATE#"=> $arResult["DATE_INSERT_FORMATED"]
						))?>
						<?= count($arResult['BASKET']);?>
						<?
						$count = count($arResult['BASKET']) % 10;
						if ($count == '1')
						{
							echo Loc::getMessage('SPOD_TPL_GOOD');
						}
						elseif ($count >= '2' && $count <= '4')
						{
							echo Loc::getMessage('SPOD_TPL_TWO_GOODS');
						}
						else
						{
							echo Loc::getMessage('SPOD_TPL_GOODS');
						}
						?>
						<?=Loc::getMessage('SPOD_TPL_SUMOF')?>
						<?=$arResult["PRICE_FORMATED"]?>
					</span>
				</div>
			</div>

			<div class="row sale-order-detail-about-order">

				<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-about-order-container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-about-order-title">
							<h3 class="sale-order-detail-about-order-title-element">
								<?= Loc::getMessage('SPOD_LIST_ORDER_INFO') ?>
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-about-order-inner-container">
							<div class="row">
								<div class="col-md-4 col-sm-6 sale-order-detail-about-order-inner-container-name">
									<div class="sale-order-detail-about-order-inner-container-name-title">
										<?
										$userName = $arResult["USER"]["NAME"] ." ". $arResult["USER"]["SECOND_NAME"] ." ". $arResult["USER"]["LAST_NAME"];
										if (strlen($userName) || strlen($arResult['FIO']))
										{
											echo Loc::getMessage('SPOD_LIST_FIO').':';
										}
										else
										{
											echo Loc::getMessage('SPOD_LOGIN').':';
										}
										?>
									</div>
									<div class="sale-order-detail-about-order-inner-container-name-detail">
										<?
										if (strlen($userName))
										{
											echo htmlspecialcharsbx($userName);
										}
										elseif (strlen($arResult['FIO']))
										{
											echo htmlspecialcharsbx($arResult['FIO']);
										}
										else
										{
											echo htmlspecialcharsbx($arResult["USER"]['LOGIN']);
										}
										?>
									</div>
									<a class="sale-order-detail-about-order-inner-container-name-read-less">
										<?= Loc::getMessage('SPOD_LIST_LESS') ?>
									</a>
									<a class="sale-order-detail-about-order-inner-container-name-read-more">
										<?= Loc::getMessage('SPOD_LIST_MORE') ?>
									</a>
								</div>

								<div class="col-md-4 col-sm-6 sale-order-detail-about-order-inner-container-status">
									<div class="sale-order-detail-about-order-inner-container-status-title">
										<?= Loc::getMessage('SPOD_LIST_CURRENT_STATUS', array(
											'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
										)) ?>
									</div>
									<div class="sale-order-detail-about-order-inner-container-status-detail">
                                        <select name="status">
                                            <option value="N" <?if($arResult["STATUS"]["ID"] == "N"):?>selected<?endif?>>Принят, ожидается оплата</option>
                                            <option value="P" <?if($arResult["STATUS"]["ID"] == "P"):?>selected<?endif?>>Принят, оплачен</option>
                                            <option value="F" <?if($arResult["STATUS"]["ID"] == "F"):?>selected<?endif?>>Выполнен</option>
                                            <option value="С" <?if($arResult['CANCELED'] == 'Y'):?>selected<?endif?>>Отменен</option>
                                        </select>
										<?
//										if ($arResult['CANCELED'] !== 'Y')
//										{
//											echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
//										}
//										else
//										{
//											echo Loc::getMessage('SPOD_ORDER_CANCELED');
//										}
										?>
									</div>
								</div>

								<div class="col-md-<?=($arParams['GUEST_MODE'] !== 'Y') ? 2 : 4?> col-sm-6 sale-order-detail-about-order-inner-container-price">
									<div class="sale-order-detail-about-order-inner-container-price-title">
										<?= Loc::getMessage('SPOD_ORDER_PRICE')?>:
									</div>
									<div class="sale-order-detail-about-order-inner-container-price-detail">
										<strong><?= $arResult["PRICE_FORMATED"]?></strong>
									</div>
                                    <div class="sale-order-detail-about-order-inner-container-price-detail">
                                        <strong><?= $arResult["PRICE_IN_VALUTE"]?> <?=$arResult["VALUTE_SHORT"]?></strong>
                                    </div>
								</div>

							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-about-order-inner-container-details">
								<h4 class="sale-order-detail-about-order-inner-container-details-title">
									<?= Loc::getMessage('SPOD_USER_INFORMATION') ?>
								</h4>
								<ul class="sale-order-detail-about-order-inner-container-details-list">
									<?
									if (strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO']))
									{
										?>
										<li class="sale-order-detail-about-order-inner-container-list-item">
											<?= Loc::getMessage('SPOD_LOGIN')?>:
											<div class="sale-order-detail-about-order-inner-container-list-item-element">
												<?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?>
											</div>
										</li>
										<?
									}
									if (strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO']))
									{
										?>
										<li class="sale-order-detail-about-order-inner-container-list-item">
											<?= Loc::getMessage('SPOD_EMAIL')?>:
											<a class="sale-order-detail-about-order-inner-container-list-item-link"
											   href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>"><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></a>
										</li>
										<?
									}

									if (isset($arResult["ORDER_PROPS"]))
									{
										foreach ($arResult["ORDER_PROPS"] as $property)
										{
											?>
											<li class="sale-order-detail-about-order-inner-container-list-item">
												<?= htmlspecialcharsbx($property['NAME']) ?>:
												<div class="sale-order-detail-about-order-inner-container-list-item-element">
													<?
													if ($property["TYPE"] == "Y/N")
													{
														echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
													}
													else
													{
														if ($property['MULTIPLE'] == 'Y'
															&& $property['TYPE'] !== 'FILE'
															&& $property['TYPE'] !== 'LOCATION')
														{
															$propertyList = unserialize($property["VALUE"]);
															foreach ($propertyList as $propertyElement)
															{
																echo $propertyElement . '</br>';
															}
														}
														elseif ($property['TYPE'] == 'FILE')
														{
															echo $property["VALUE"];
														}
														else
														{
															echo htmlspecialcharsbx($property["VALUE"]);
														}
													}
													?>
												</div>
											</li>
											<?
										}
									}
									?>
								</ul>
								<?
								if (strlen($arResult["USER_DESCRIPTION"]))
								{
									?>
									<h4 class="sale-order-detail-about-order-inner-container-details-title sale-order-detail-about-order-inner-container-comments">
										<?= Loc::getMessage('SPOD_ORDER_DESC') ?>
									</h4>
									<div class="col-xs-12 sale-order-detail-about-order-inner-container-list-item-element">
										<?=nl2br(htmlspecialcharsbx($arResult["USER_DESCRIPTION"]))?>
									</div>
									<?
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="row sale-order-detail-payment-options">
                <div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-title">
                            <h3 class="sale-order-detail-payment-options-title-element">
                                <?= Loc::getMessage('SPOD_ORDER_PAYMENT') ?>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?//print_pre($arResult['PAYMENT'])?>
                            <?
                            foreach ($arResult['PAYMENT'] as $payment)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="col-md-8 col-sm-7 col-xs-15">
                                                <div class="sale-order-detail-payment-options-methods-info-title">
                                                    <div class="sale-order-detail-methods-title">
                                                        <br>
                                                        <?
                                                        $paymentData[$payment['ACCOUNT_NUMBER']] = array(
                                                            "payment" => $payment['ACCOUNT_NUMBER'],
                                                            "order" => $arResult['ACCOUNT_NUMBER'],
                                                            "allow_inner" => $arParams['ALLOW_INNER'],
                                                            "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                                            "refresh_prices" => $arParams['REFRESH_PRICES'],
                                                            "path_to_payment" => $arParams['PATH_TO_PAYMENT']
                                                        );
                                                        $paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL')." ".Loc::getMessage('SPOD_NUM_SIGN').$payment['ACCOUNT_NUMBER'];
                                                        if(isset($payment['DATE_BILL']))
                                                        {
                                                            $paymentSubTitle .= " ".Loc::getMessage('SPOD_FROM')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
                                                        }
                                                        $paymentSubTitle .=",";
                                                        echo htmlspecialcharsbx($paymentSubTitle);
                                                        ?>
                                                        <span class="sale-order-list-payment-title-element"><?=$payment['PAY_SYSTEM_NAME']?></span>
                                                        <?
                                                        if ($payment['PAID'] === 'Y')
                                                        {
                                                            ?>
                                                            <span class="sale-order-detail-payment-options-methods-info-title-status-success">
																	<?=Loc::getMessage('SPOD_PAYMENT_PAID')?></span>
                                                        <?
                                                        }



                                                        else
                                                        {
                                                            ?>
                                                            <span class="sale-order-detail-payment-options-methods-info-title-status-alert">
																	<?=Loc::getMessage('SPOD_PAYMENT_UNPAID')?></span>
                                                        <?
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <?
                                                if (!empty($payment['CHECK_DATA']))
                                                {
                                                    $listCheckLinks = "";
                                                    foreach ($payment['CHECK_DATA'] as $checkInfo)
                                                    {
                                                        $title = Loc::getMessage('SPOD_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                                        if (strlen($checkInfo['LINK']) > 0)
                                                        {
                                                            $link = $checkInfo['LINK'];
                                                            $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                                                        }
                                                    }
                                                    if (strlen($listCheckLinks) > 0)
                                                    {
                                                        ?>
                                                        <div class="sale-order-detail-payment-options-methods-info-total-check">
                                                            <div class="sale-order-detail-sum-check-left"><?= Loc::getMessage('SPOD_CHECK_TITLE')?>:</div>
                                                            <div class="sale-order-detail-sum-check-left">
                                                                <?=$listCheckLinks?>
                                                            </div>
                                                        </div>
                                                    <?
                                                    }
                                                }
                                                if (
                                                    $payment['PAID'] !== 'Y'
                                                    && $arResult['CANCELED'] !== 'Y'
                                                    && $arParams['GUEST_MODE'] !== 'Y'
                                                    && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
                                                )
                                                {
                                                    ?>
                                                <?
                                                }
                                                ?>
<!--                                                --><?//
//                                                if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y')
//                                                {
//                                                    ?>
<!--                                                    <div class="sale-order-detail-status-restricted-message-block">-->
<!--                                                        <span class="sale-order-detail-status-restricted-message">--><?//=Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE')?><!--</span>-->
<!--                                                    </div>-->
<!--                                                --><?//
//                                                }
//                                                ?>
                                            </div>
                                            <?
                                            if(false)
                                            //if ($payment['PAY_SYSTEM']["IS_CASH"] !== "Y")
                                            {
                                                ?>
                                                <div class="col-md-2 col-sm-12 col-xs-12 sale-order-detail-payment-options-methods-button-container">
                                                    <?
                                                    if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N")
                                                    {
                                                        ?>
                                                        <a class="btn-theme sale-order-detail-payment-options-methods-button-element-new-window"
                                                           target="_blank"
                                                           href="<?=htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE'])?>">
                                                            <?= Loc::getMessage('SPOD_ORDER_PAY') ?>
                                                        </a>
                                                    <?
                                                    }
                                                    else
                                                    {
                                                        if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N")
                                                        {
                                                            ?>
                                                            <a class="btn-theme sale-order-detail-payment-options-methods-button-element inactive-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
                                                        <?
                                                        }
                                                        else
                                                        {
                                                            ?>
<!--                                                            <a class="btn-theme sale-order-detail-payment-options-methods-button-element active-button">--><?//= Loc::getMessage('SPOD_ORDER_PAY') ?><!--</a>-->
                                                        <?
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?
                                            }
                                            ?>
                                            <div class="sale-order-detail-payment-inner-row-template col-md-offset-3 col-sm-offset-5 col-md-5 col-sm-10 col-xs-12">
                                                <a class="sale-order-list-cancel-payment">
                                                    <i class="fa fa-long-arrow-left"></i> <?=Loc::getMessage('SPOD_CANCEL_PAYMENT')?>
                                                </a>
                                            </div>
                                        </div>
                                        <?
                                        if ($payment["PAID"] !== "Y"
                                            && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                                            && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                                            && $arResult['CANCELED'] !== 'Y'
                                            && $arResult["IS_ALLOW_PAY"] !== "N")
                                        {
                                            ?>
                                            <div class="row sale-order-detail-payment-options-methods-template col-md-12 col-sm-12 col-xs-12">
														<span class="sale-paysystem-close active-button">
															<span class="sale-paysystem-close-item sale-order-payment-cancel"></span><!--sale-paysystem-close-item-->
														</span><!--sale-paysystem-close-->
                                                <?=$payment['BUFFERED_OUTPUT']?>
                                                <!--<a class="sale-order-payment-cancel">--><?//= Loc::getMessage('SPOD_CANCEL_PAY') ?><!--</a>-->
                                            </div>
                                        <?
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row sale-order-detail-payment-options">
                <div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-title">
                            <h3 class="sale-order-detail-payment-options-title-element">
                                <?= Loc::getMessage('SPOD_ORDER_SHIPMENT') ?>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <div class="sale-order-detail-payment-options-methods-shipment-list-item" style="font-size: 14px">
                                <?foreach ($arResult['SHIPMENT'] as $shipment):?>
                                    <?= Loc::getMessage('SPOD_ORDER_DELIVERY')?>: <?= htmlspecialcharsbx($shipment["DELIVERY_NAME"])?>
                                <?endforeach?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<div class="row sale-order-detail-payment-options-order-content">

				<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-order-content-container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 sale-order-detail-payment-options-order-content-title">
							<h3 class="sale-order-detail-payment-options-order-content-title-element">
								<?= Loc::getMessage('SPOD_ORDER_BASKET')?>
							</h3>
						</div>
						<div class="sale-order-detail-order-section bx-active">
							<div class="sale-order-detail-order-section-content container-fluid">
								<div class="sale-order-detail-order-table-fade sale-order-detail-order-table-fade-right">
									<div style="width: 100%; overflow-x: auto; overflow-y: hidden;">
										<div class="sale-order-detail-order-item-table">
											<div class="sale-order-detail-order-item-tr hidden-sm hidden-xs">
												<div class="sale-order-detail-order-item-td" style="padding-bottom: 5px;">
													<div class="sale-order-detail-order-item-td-title">
														<?= Loc::getMessage('SPOD_NAME')?>
													</div>
												</div>
												<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right" style="padding-bottom: 5px;">
													<div class="sale-order-detail-order-item-td-title">
														<?= Loc::getMessage('SPOD_PRICE')?>
													</div>
												</div>
												<?
												if (strlen($arResult["SHOW_DISCOUNT_TAB"]))
												{
													?>
													<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right"
														 style="padding-bottom: 5px;">
														<div class="sale-order-detail-order-item-td-title">
															<?= Loc::getMessage('SPOD_DISCOUNT') ?>
														</div>
													</div>
													<?
												}
												?>
												<div class="sale-order-detail-order-item-nth-4p1"></div>
												<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right" style="padding-bottom: 5px;">
													<div class="sale-order-detail-order-item-td-title">
														<?= Loc::getMessage('SPOD_QUANTITY')?>
													</div>
												</div>
												<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right" style="padding-bottom: 5px;">
													<div class="sale-order-detail-order-item-td-title">
														<?= Loc::getMessage('SPOD_ORDER_PRICE')?>
													</div>
												</div>
											</div>
											<?
											foreach ($arResult['BASKET'] as $basketItem)
											{
												?>
												<div class="sale-order-detail-order-item-tr sale-order-detail-order-basket-info sale-order-detail-order-item-tr-first">
													<div class="sale-order-detail-order-item-td" style="min-width: 300px;">
														<div class="sale-order-detail-order-item-block">
															<div class="sale-order-detail-order-item-img-block">
																<a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
																	<?
																	if (strlen($basketItem['PICTURE']['SRC']))
																	{
																		$imageSrc = $basketItem['PICTURE']['SRC'];
																	}
																	else
																	{
																		$imageSrc = $this->GetFolder().'/images/no_photo.png';
																	}
																	?>
																	<div class="sale-order-detail-order-item-imgcontainer"
																		 style="background-image: url(<?=$imageSrc?>);
																			 background-image: -webkit-image-set(url(<?=$imageSrc?>) 1x,
																			 url(<?=$imageSrc?>) 2x)">
																	</div>
																</a>
															</div>
															<div class="sale-order-detail-order-item-content">
																<div class="sale-order-detail-order-item-title">

                                                                        <a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
																		    <?=htmlspecialcharsbx($basketItem['NAME'])?>
																	    </a>

																</div>
																<?
																if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS']))
																{
																	foreach ($basketItem['PROPS'] as $itemProps)
																	{
																		?>
																		<div class="sale-order-detail-order-item-color">
																		<span class="sale-order-detail-order-item-color-name">
																			<?=htmlspecialcharsbx($itemProps['NAME'])?>:</span>
																			<span class="sale-order-detail-order-item-color-type">
																			<?=htmlspecialcharsbx($itemProps['VALUE'])?></span>
																		</div>
																		<?
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
														<div class="sale-order-detail-order-item-td-title col-xs-7 col-sm-5 visible-xs visible-sm">
															<?= Loc::getMessage('SPOD_PRICE')?>
														</div>
														<div class="sale-order-detail-order-item-td-text">
															<strong class="bx-price"><?=$basketItem['BASE_PRICE_FORMATED']?></strong>
														</div>
													</div>
													<?
													if (strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"]))
													{
														?>
														<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
															<div class="sale-order-detail-order-item-td-title col-xs-7 col-sm-5 visible-xs visible-sm">
																<?= Loc::getMessage('SPOD_DISCOUNT') ?>
															</div>
															<div class="sale-order-detail-order-item-td-text">
																<strong class="bx-price"><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></strong>
															</div>
														</div>
														<?
													}
													elseif (strlen($arResult["SHOW_DISCOUNT_TAB"]))
													{
														?>
														<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
															<div class="sale-order-detail-order-item-td-title col-xs-7 col-sm-5 visible-xs visible-sm">
																<?= Loc::getMessage('SPOD_DISCOUNT') ?>
															</div>
															<div class="sale-order-detail-order-item-td-text">
																<strong class="bx-price"></strong>
															</div>
														</div>
														<?
													}
													?>
													<div class="sale-order-detail-order-item-nth-4p1"></div>
													<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
														<div class="sale-order-detail-order-item-td-title col-xs-7 col-sm-5 visible-xs visible-sm">
															<?= Loc::getMessage('SPOD_QUANTITY')?>
														</div>
														<div class="sale-order-detail-order-item-td-text">
														<strong><?=$basketItem['QUANTITY']?>&nbsp;
															<?
															if (strlen($basketItem['MEASURE_NAME']))
															{
																echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
															}
															else
															{
																echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
															}
															?></strong>
														</div>
													</div>
													<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
														<div class="sale-order-detail-order-item-td-title col-xs-7 col-sm-5 visible-xs visible-sm"><?= Loc::getMessage('SPOD_ORDER_PRICE')?></div>
														<div class="sale-order-detail-order-item-td-text">
															<strong class="bx-price all"><?=$basketItem['FORMATED_SUM']?></strong><br>
                                                            <strong class="bx-price all"><?=$basketItem['PRICE_ALL']?> <?=$arResult["VALUTE_SHORT"]?></strong>
														</div>
													</div>
												</div>
												<?
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row sale-order-detail-total-payment">
				<div class="col-md-7 col-md-offset-5 col-sm-12 col-xs-12 sale-order-detail-total-payment-container">
					<div class="row">
						<ul class="col-md-7 col-sm-6 col-xs-6 sale-order-detail-total-payment-list-left">
							<?
							if (floatval($arResult["ORDER_WEIGHT"]))
							{
								?>
								<li class="sale-order-detail-total-payment-list-left-item">
									<strong><?= Loc::getMessage('SPOD_TOTAL_WEIGHT')?>:</strong>
								</li>
								<?
							}

							//if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED']))
                            //не выводилось при нулевой стоимости доставки т.е. при сумма товаров == итого
                            //попросили выводить всегда
                            if (!empty($arResult['PRODUCT_SUM_FORMATED']))
							{
								?>
								<li class="sale-order-detail-total-payment-list-left-item">
                                    <strong><?= Loc::getMessage('SPOD_COMMON_SUM')?>:</strong>
								</li>
								<?
							}

							if (strlen($arResult["PRICE_DELIVERY_FORMATED"]))
							{
								?>
								<li class="sale-order-detail-total-payment-list-left-item">
									<strong><?= Loc::getMessage('SPOD_DELIVERY')?>:</strong>
								</li>
								<?
							}

							if ((float)$arResult["TAX_VALUE"] > 0)
							{
								?>
								<li class="sale-order-detail-total-payment-list-left-item">
									<?= Loc::getMessage('SPOD_TAX') ?>:
								</li>
								<?
							}
							?>
							<li class="sale-order-detail-total-payment-list-left-item"><strong><?= Loc::getMessage('SPOD_SUMMARY')?>:</strong></li>
						</ul>
						<ul class="col-md-5 col-sm-6 col-xs-6 sale-order-detail-total-payment-list-right">
							<?
							if (floatval($arResult["ORDER_WEIGHT"]))
							{
								?>
								<li class="sale-order-detail-total-payment-list-right-item"><strong><?= $arResult['ORDER_WEIGHT_FORMATED'] ?></strong></li>
								<?
							}

							//if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED']))
                            //не выводилось при нулевой стоимости доставки т.е. при сумма товаров == итого
                            //попросили выводить всегда
                            if (!empty($arResult['PRODUCT_SUM_FORMATED']))
							{
								?>
								<li class="sale-order-detail-total-payment-list-right-item"><strong><?=$arResult['PRODUCT_SUM_FORMATED']?></strong> <strong>(<?=$arResult["PRICE_ALL_POSITIONS_REG"]?> <?=$arResult["VALUTE_SHORT"]?>)</strong></li>
								<?
							}

							if (strlen($arResult["PRICE_DELIVERY_FORMATED"]))
							{
								?>
								<li class="sale-order-detail-total-payment-list-right-item"><strong><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></strong> <strong>(<?=$arResult["PRICE_IN_VALUTE"] - $arResult["PRICE_ALL_POSITIONS_REG"] ?> <?=$arResult["VALUTE_SHORT"]?>)</strong></li>
								<?
							}

							if ((float)$arResult["TAX_VALUE"] > 0)
							{
								?>
								<li class="sale-order-detail-total-payment-list-right-item"><?= $arResult["TAX_VALUE_FORMATED"] ?></li>
								<?
							}
							?>
							<li class="sale-order-detail-total-payment-list-right-item"><strong><?=$arResult['PRICE_FORMATED']?></strong> <strong>(<?= $arResult["PRICE_IN_VALUTE"]?> <?=$arResult["VALUTE_SHORT"]?>)</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div><!--sale-order-detail-general-->

        <input style="float: right; margin-top: 25px;" type="submit" class="button button--bgred button--big" name="save" value="Сохранить">


    </form>
	</div>



	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"paymentList" => $paymentData
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
	</script>
<?
}
?>
<br>

