#!/usr/bin/php
<?php

/**
 * Maximum flow problem
 * (Ford–Fulkerson algorithm)
 * http://en.wikipedia.org/wiki/Ford–Fulkerson_algorithm
 * http://en.wikibooks.org/wiki/Algorithms/Hill_Climbing
 * from "Python implementation"
 * 2011 (c) Demin Victor <mail@vdemin.com>
 **/

class Edge
{
  public $source;
  public $sink;
  public $capacity;
  
  public function Edge ($u, $v, $w)
  {
    $this->source   = $u;
    $this->sink     = $v;
    $this->capacity = $w;
  }
  
  public function __toString()
  {
    return  $this->source . "->" . $this->sink  . " : "  . $this->capacity;
  }
}

class FlowNetwork
{
  /**
   * Array of Adjacency relation,
   * vertex as key.
   * $vertex => array($edge1, $edge2)
   */
  private $adj;
  
  /**
   * Array of flow
   * $edge => value
   */
  private $flow;
  
  /**
   * Add vertex
   * @param: string $vertex;
   */
  public function add_vertex($vertex)
  {
    $this->adj[$vertex] = '';
  }

  /**
   * Get Edges for vertex
   * @param: string $vertex;
   * @param: array $edges;
   */
  public function get_edges($vertex)
  {
    return $this->adj[$vertex];
  }
  
  /**
   * Add edge
   * @param: vertex $source;
   * @param: vertex $sink;
   * @param: int $capacity;
   */
  public function add_edge($u, $v, $w=0)
  {
    if ( $u == $v )
      return -1;
    $edge  = new Edge($u,$v,$w);
    $redge = new Edge($v,$u,0);
    $edge->redge  =& $redge;
    $redge->redge =& $edge;
    $this->adj[$u][] = $edge;
    $this->adj[$v][] = $redge;
    $this->flow[(string) $edge]  = 0;
    $this->flow[(string) $redge] = 0;
    
    return 0;
  }
  
  /**
   * Find path
   * @param: vertex $source;
   * @param: vertex $sink;
   * @param: array $path; 
   * @result: array( array($edge, $residual), ... );
   */
  public function find_path($source, $sink, $path)
  {
    if ( $source == $sink )
      return $path;
    foreach ($this->get_edges($source) as $edge)
    {
      $residual = $edge->capacity - $this->flow[(string) $edge];
      if ( $residual > 0  && !in_array(array($edge, $residual), $path) )
      {
        $path[] = array($edge, $residual);
        $result = $this->find_path( $edge->sink, $sink, $path );
        if ($result)
          return $result;
      }
    }
  }  
  
  /**
   * Find max flow
   * @param: vertex $source;
   * @param: vertex $sink;
   * @result: max flow;
   */
  public function max_flow($source, $sink)
  {
    $path = $this->find_path($source, $sink, array());
    $max = 0;
    while ( !empty($path) )
    {
      $res = array();
      foreach ($path as $p)
      {
        $res[] = $p[1];
      }
      $flow = min($res);
      foreach ($path as $p)
      {
        $edge = $p[0];
        $res = $p[1];
        $this->flow[(string) $edge] += $flow;
        $this->flow[(string) $edge->redge] -= $flow;
        $path = $this->find_path($source, $sink, array());
      }

      $max += $flow;
    }
    
    //return $this->flow;
    return $max;
  }
}


$lines = array(
'Madrid Barcelona Madrid,Segovia,10 Madrid,Toledo,40 Segovia,Toledo,30 Segovia,Barcelona,50 Toledo,Madrid,30 Toledo,Barcelona,100 Barcelona,Segovia,25 Barcelona,Toledo,400',
'Sol Palacio Sol,Cortes,3 Sol,Embajadores,3 Cortes,Tribunal,4 Tribunal,Sol,3 Tribunal,Embajadores,2 Embajadores,Retiro,3 Embajadores,Callao,6 Retiro,Cortes,1 Retiro,Palacio,1',
);


//$lines = file('php://stdin');
$lines = array_map('trim', $lines);

foreach($lines as $line) {
    $g = new FlowNetwork();
    
    $data = explode(' ', $line);
    //$num = array_shift($data);
    $origenProblema = array_shift($data);
    $destinoProblema = array_shift($data);
    
    $vertexs = array();
    foreach($data as $nodo) {
        list($origen, $destino, $capacidad) = explode(',', $nodo);
        if(!in_array($origen, $vertexs)) $vertexs[] = $origen;
        if(!in_array($destino, $vertexs)) $vertexs[] = $destino;
    }

    
    foreach($vertexs as $vertex) {
        $g->add_vertex($vertex);
    }
    
    foreach($data as $nodo) {
        list($origen, $destino, $capacidad) = explode(',', $nodo);
        $g->add_edge($origen, $destino, $capacidad);
    }
        
    var_dump($g->max_flow($origenProblema, $destinoProblema) );
    unset($g);
}