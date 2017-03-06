<?php

namespace Oro\Bundle\TranslationBundle\Datagrid\Extension\MassActions;

use Oro\Bundle\DataGridBundle\Extension\Action\ActionConfiguration;
use Oro\Bundle\DataGridBundle\Extension\MassAction\Actions\AbstractMassAction;

class ResetTranslationsMassAction extends AbstractMassAction
{
    /** @var array */
    protected $requiredOptions = ['handler', 'data_identifier'];

    /**
     * {@inheritDoc}
     */
    public function setOptions(ActionConfiguration $options)
    {
        if (empty($options['handler'])) {
            $options['handler'] = 'oro_translation.mass_actions.reset_translation_handler';
        }

        if (empty($options['route'])) {
            $options['route'] = 'oro_translation_mass_reset';
        }

        if (empty($options['frontend_handle'])) {
            $options['frontend_handle'] = 'ajax';
        }

        if (empty($options['route_parameters'])) {
            $options['route_parameters'] = [];
        }

        return parent::setOptions($options);
    }
}
