<?php
/**
 * Created by Metagento.com
 * Date: 9/7/2018
 */

namespace Metagento\StockQty\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action
{
	public $stockRepository;
	
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
		\Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
    ) 
	{
        parent::__construct($context);
        $this->stockState = $stockState;
		$this->stockRepository = $stockItemRepository;
    }

    public function getStockItem($productId)
    {
        return $this->stockRepository->get($productId);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $html      = '';
        $productId = $this->getRequest()->getParam('product_id');
        if ($productId) {
            $stockQty = $this->getStockItem($productId);//$this->stockState->getStockQty($productId);
            $html     = __("Qty: ") . $stockQty->getQty();
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create('json');
        return $result->setData(['content' => $html]);
    }
}
