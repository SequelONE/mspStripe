<?php
// require the autoload
require 'vendor/autoload.php';
if (!class_exists('msPaymentInterface')) {
	require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}

class Stripe extends msPaymentHandler implements msPaymentInterface {
	public function view() {
		$tpl = $this->getProperty('cart_tpl', 'scStripeCart');
		$footerTpl = $this->getProperty('cart_footer_tpl', 'scStripeFooter');
		$phs = array(
			'publishable_key' => addslashes($this->getProperty('publishable_key', 'ENTER YOUR KEY')),
			'method_id' => $this->method->get('id'),
		);
		$head = $this->simplecart->getChunk($footerTpl, $phs);
		$this->modx->regClientHTMLBlock($head);
		return $this->simplecart->getChunk($tpl, $phs);
	}
	public function submit() {
		if (!$this->initStripe()) {
			return false;
		}
		// Get the submitted token from the front-end
		$token = $this->getField('stripeToken');
		$this->order->addLog('Stripe Token', $token);
		// SimpleCart stores totals in decimal values, so we need to turn that into cents for Stripe
		$amount = $this->order->get('total');
		$amount = intval($amount * 100);
		// Get the currency
		$currency = $this->getProperty('currency', 'EUR');
		$currency = strtolower($currency);
		// Get the description
		$content = $this->modx->lexicon('simplecart.methods.yourorderat');
		$chunk = $this->modx->newObject('modChunk');
		$chunk->setCacheable(false);
		$chunk->setContent($content);
		$description = $chunk->process();
		try {
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount, // amount in cents, again
				"currency" => $currency,
				"source" => $token,
				"description" => $description
			));
		} catch(\Stripe\Error\Card $e) {
			// The card has been declined
			$this->order->addLog('Card Declined', $e->getMessage());
			$this->order->set('status', 'payment_failed');
			$this->order->save();
			return false;
		} catch(\Stripe\Error\Base $e) {
			$this->order->addLog('Stripe Error', $e->getMessage());
			$this->order->set('status', 'payment_failed');
			$this->order->save();
			return false;
		} catch(Exception $e) {
			$this->order->addLog('Uncaught Exception', $e->getMessage());
			$this->order->set('status', 'payment_failed');
			$this->order->save();
			return false;
		}
		// log the finishing status
		$this->order->addLog('Stripe Charge ID', $charge['id']);
		$this->order->addLog('Stripe Card', $charge['source']['brand'] . ' ' . $charge['source']['last4']);
		$this->order->setStatus('finished');
		$this->order->save();
		return true;
	}
	public function verify() {
		if (!$this->initStripe()) {
			return false;
		}
		$chargeId = $this->order->getLog('Stripe Charge ID');
		if (empty($chargeId)) {
			return false;
		}
		try {
			$charge = \Stripe\Charge::retrieve($chargeId);
		} catch (\Exception $e) {
			$this->order->addLog('Stripe Verify Fail', $e->getMessage());
			return false;
		}
		if ($charge && $charge['status'] === 'succeeded') {
			return true;
		}
		return false;
	}
	/** CUSTOM METHODS **/
	protected function initStripe() {
		$key = $this->getProperty('secret_key');
		if (empty($key)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, 'Unable to initiate Stripe gateway for SimpleCart: no secret key is set on the payment method.');
			return false;
		}
		\Stripe\Stripe::setApiKey($key);
		return true;
	}
}