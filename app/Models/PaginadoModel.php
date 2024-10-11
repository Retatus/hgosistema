<?php 

namespace App\Models;
use CodeIgniter\Model;

class PaginadoModel extends Model
{          
    public function pagina($page, $tpages, $adjacents) {
        $tpages = ceil($tpages/10);
        $prevlabel = "&lsaquo; Anterior";
        $nextlabel = "Siguiente &rsaquo;";
        $out = '<ul class="pagination pagination-sm m-0 float-right">';        
        // previous label    
        if($page==1) {
            $out.= "<li class='page-item disabled'><a class='page-link'>$prevlabel</a></li>";
        } else if($page==2) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>$prevlabel</a></li>";
        }else {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".($page-1).")'>$prevlabel</a></li>";
        }        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>1</a></li>";
        }
        // interval
        if($page>($adjacents+2)) {
            $out.= "<li class='page-item'><a>...</a></li>";
        }    
        // pages    
        $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
        $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
        for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$page) {
                $out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
            }else if($i==1) {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
            }else {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".$i.")'>$i</a></li>";
            }
        }    
        // interval    
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li class='page-item'><a>...</a></li>";
        }    
        // last    
        if($page<($tpages-$adjacents)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load($tpages)'>$tpages</a></li>";
        }    
        // next    
        if($page<$tpages) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".($page+1).")'>$nextlabel</a></li>";
        }else {
            $out.= "<li class='page-item disabled'><a class='page-link'>$nextlabel</a></li>";
        }        
        $out.= "</ul>";
        return $out;
    }
}

?>