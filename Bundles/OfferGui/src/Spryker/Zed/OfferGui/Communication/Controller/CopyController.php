<?php


namespace Spryker\Zed\OfferGui\Communication\Controller;


use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OfferResponseTransfer;
use Generated\Shared\Transfer\OfferTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Client\Session\SessionClientInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Cart\Business\CartFacadeInterface;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Messenger\Business\MessengerFacadeInterface;
use Spryker\Zed\OfferGui\Communication\Form\Offer\CreateOfferType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Spryker\Zed\OfferGui\Communication\OfferGuiCommunicationFactory getFactory()
 */
class CopyController extends AbstractController
{
    public const PARAM_ID_OFFER = 'id-offer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|Response
     */
    public function indexAction(Request $request)
    {
        $idOffer = $request->get(static::PARAM_ID_OFFER);

        $offerTransfer = new OfferTransfer();
        $offerTransfer->setIdOffer($idOffer);
        $offerTransfer = $this->getFactory()
            ->getOfferFacade()
            ->getOfferById($offerTransfer);

        $offerTransfer->setCustomerReference(null);
        $offerTransfer->setCustomer(new CustomerTransfer());

        $offerJson = \json_encode($offerTransfer->toArray());
        $offerKey = md5($offerJson);

        /** @var SessionClientInterface $sessionClient */
        $sessionClient = Locator::getInstance()->session()->client();
        $sessionClient->set($offerKey, $offerJson);

        $redirectUrl = Url::generate(
            '/offer-gui/edit',
            [EditController::PARAM_KEY_INITIAL_OFFER => $offerKey]
        )->build();

        return $this->redirectResponse($redirectUrl);
    }
}