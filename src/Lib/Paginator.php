<?php
namespace App\Lib;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;
class Paginator
{

    private $request;
    private $container;

    public $totalPages=0;
    public $currentPage=0;
    public $recordsPerPage=20;
    public $pageList=[];
    public $totalItems = 0;

    public $recordsPerPageList = [5, 10, 20, 50, 100];
    public function __construct(Request $request, Container $container)
    {
        $this->request = $request;
        $this->container = $container;
        $this->recordsPerPage = $this->request->query->get('limit', $this->container->getParameter('pagination_records_per_page'));
        $this->currentPage = $this->request->query->get('page', 0);
     }
    
    public function getCurrentPage(){
        return $this->currentPage;
    }

    public function getRecordsPerPage(){
        return $this->recordsPerPage;
    }

    public function setTotalPages($totalcount)
    {
        $this->totalItems = $totalcount;
        $this->totalPages=ceil($totalcount / $this->recordsPerPage);
        $this->pageList = $this->getPagesList();
        return $this->totalPages;
    }
 
    public function getTotalPages()
    {
        return $this->totalPages;
    }
 
    public function getPagesList()
    {
        $pageCount = 5;
        if ($this->totalPages <= $pageCount) //Less than total 5 pages
            return array(1, 2, 3, 4, 5);
 
        if($this->currentPage <=3)
            return array(1,2,3,4,5);
 
        $i = $pageCount;
        $r=array();
        $half = floor($pageCount / 2);
        if ($this->currentPage + $half > $this->totalPages) // Close to end
        {
            while ($i >= 1)
            {
                $r[] = $this->totalPages - $i + 1;
                $i--;
            }
            return $r;
        } else
        {
            while ($i >= 1)
            {
                $r[] = $this->currentPage - $i + $half + 1;
                $i--;
            }
            return $r;
        }
    }
}
 
?>