<?php
declare(strict_types=1);

namespace App\Handler;

use App\Handler\Form\RegisterForEventForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\Element;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Render the march first fundraiser page
 *
 * @author Marcel Kempf <marcel.kempf@check24.de>
 */
final class MarchFundraiserHandler implements RequestHandlerInterface
{

    /** @var TemplateRendererInterface */
    private $template;

    /** @var TranslatorInterface */
    private $translator;

    /** @var AdapterInterface */
    private $db;

    /**
     * The MarchFundraiserHandler constructor.
     *
     * @param TemplateRendererInterface $template
     * @param TranslatorInterface $translator
     * @param AdapterInterface $db
     */
    public function __construct(
        TemplateRendererInterface $template,
        TranslatorInterface $translator,
        AdapterInterface $db
    ) {
        $this->template = $template;
        $this->translator = $translator;
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $form = new RegisterForEventForm([
            'gthday_sidehandle' => $this->translator->translate('gthday.events.bowltea.headline'),
            'gthday_gongfu' => $this->translator->translate('gthday.events.gongfu.headline'),
            'gthday_both' => $this->translator->translate('gthday.events.both'),
        ]);

        if (strtolower($request->getMethod()) === 'post') {
            $form->setData($request->getParsedBody());
            if ($form->isValid()) {
                $data = $form->getData();
                $stmt = $this->db->getDriver()->createStatement(
                    'INSERT INTO event_registration (firstname, lastname, event_name, email) ' .
                    'VALUES(:firstname, :lastname, :event_name, :email)'
                );
                $stmt->prepare();
                $stmt->execute([
                    'firstname' => $data['firstName'],
                    'lastname' => $data['lastName'],
                    'event_name' => $data['event'],
                    'email' => $data['email'],
                ]);

                return new HtmlResponse($this->template->render('app::march-fundraiser', [
                    'translator' => $this->translator,
                    'form' => $form,
                    'success' => true,
                ]));
            }

            /** @var Element $element */
            foreach ($form->getElements() as $element) {
                if (empty($element->getMessages())) {
                    continue;
                }
                $element->setAttribute('class', 'input-error');
            }

            return new HtmlResponse($this->template->render('app::march-fundraiser', [
                'translator' => $this->translator,
                'form' => $form,
            ]));
        }

        return new HtmlResponse($this->template->render('app::march-fundraiser', [
            'translator' => $this->translator,
            'form' => $form,
        ]));
    }
}