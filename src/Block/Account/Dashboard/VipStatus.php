<?php namespace Meanbee\VipMembership\Block\Account\Dashboard;

use Meanbee\VipMembership\Api\VipCustomerManagementInterface;

class VipStatus  extends \Magento\Framework\View\Element\Template
{
    /** @var \Magento\Customer\Helper\Session\CurrentCustomer  */
    protected $currentCustomer;

    /** @var \Magento\Framework\Filesystem  */
    protected $filesystem;

    /** @var \Magento\Store\Model\StoreManagerInterface  */
    protected $storeManager;

    protected $customerFactory;

    protected $vipCustomerManagement;

    /**
     * Avatar constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Framework\Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        VipCustomerManagementInterface $vipCustomerManagement,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->filesystem = $context->getFilesystem();
        $this->storeManager = $context->getStoreManager();
        $this->customerFactory = $customerFactory;
        $this->vipCustomerManagement = $vipCustomerManagement;

        parent::__construct($context, $data);
    }

    /**
     * Get the logged in customer
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getDaysLeft()
    {
        return $this->vipCustomerManagement->getDaysLeft($this->getCustomer());
    }

    public function toHtml()
    {
        if (!$this->vipCustomerManagement->isVip($this->getCustomer())) {
            return '';
        }

        return parent::toHtml();
    }

}
