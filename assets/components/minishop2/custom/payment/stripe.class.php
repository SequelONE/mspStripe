<?php
if (!class_exists('msPaymentInterface')) {
	require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}
class Stripe extends msPaymentHandler implements msPaymentInterface
{
	public $modx;
	function __construct(xPDOObject $object, $config = array())
	{
		$this->modx = &$object->xpdo;
		//parent::__construct($object, $config);
	}
	public function send(msOrder $order)
	{
		$link = $this->getPaymentLink($order);
		return $this->success('', array('redirect' => $link));
	}
	public function getPaymentLink(msOrder $order)
	{
		$msppk_snippet_page_id = $this->modx->getOption('msppaykeeper_snippet_page_id');
		$order_num = $order->get('num');
		//$sum = number_format($order->get('cost'), 2, '.', '');
		$request = array(
			'order_num' => $order_num,
		);
		
		$link = $this->modx->makeUrl($msppk_snippet_page_id, '', $request);
		//$this->modx->log(1,$link);
		return $link;
	}
}