<?php
namespace Ixoil\StockMarketBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of ChartController
 *
 * @author OXIND
 */
/**
 * @Route("/chart")
 */
class ChartController extends Controller
{
    /**
     * @Route("/{symbol}", name="ixoil_stockmarket_chartdata")
     */
    public function indexAction($symbol)
    {
        $request = $this->get('request');
        
       // if ($request->isXmlHttpRequest())
        {
            $symbol = strtoupper($symbol);
            $stockValueManger = $this->get('ixoil_stockmarket.stockvalue.manager');
            $seriesData = $stockValueManger->getSeriesDataForSymbol($symbol);

            $response = new Response(json_encode($seriesData));
            $response->headers->set('Content-Type', 'application/json');
            
            return $response;
        }
        
    }

}
