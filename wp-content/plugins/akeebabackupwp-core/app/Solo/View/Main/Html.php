<?php
/**
 * @package     Solo
 * @copyright   2014 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license     GNU GPL version 3 or later
 */

namespace Solo\View\Main;

use Akeeba\Engine\Platform;
use Awf\Mvc\Model;
use Awf\Mvc\View;
use Solo\Model\Main;
use Solo\Model\Stats;
use Solo\Model\Update;

class Html extends \Solo\View\Html
{
	public function onBeforeMain()
	{
		/** @var Main $model */
		$model = $this->getModel();
		$session = $this->container->segment;

		$this->profile = Platform::getInstance()->get_active_profile();
		$this->profileList = $model->getProfileList();
		$this->quickIconProfiles = $model->getQuickIconProfiles();
		$this->latestBackupDetails = $model->getLatestBackupDetails();

		if (!$this->container->segment->get('insideCMS', false))
		{
			$this->configUrl = $model->getConfigUrl();
		}
		$this->backupUrl = $model->getBackupUrl();

		$this->needsDownloadId = $model->needsDownloadID();
		$this->warnCoreDownloadId = $model->mustWarnAboutDownloadIdInCore();

		$this->frontEndSecretWordIssue = $model->getFrontendSecretWordError();
		$this->newSecretWord = $session->get('newSecretWord', null);

		$this->desktop_notifications = Platform::getInstance()->get_platform_configuration_option('desktop_notifications', '0') ? 1 : 0;

        /** @var Stats $statsModel */
        $statsModel = Model::getTmpInstance($this->container->application_name, 'Stats', $this->container);
        $this->statsIframe = $statsModel->collectStatistics(true);

		return true;
	}
}