<?php 
ini_set('display_errors', 'on');
error_reporting(-1);
Design::display();

class Design
{
    const COMMAND = 'bash ./check_servers.sh php';

    public static function display()
    {
        $d = new self;
        echo $d->getPage();
    }

    public function getPage()
    {
        $page = <<<R
<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>Server check</title><link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"></head><body>
<div class="w3-card-4 w3-margin w3-padding w3-round-xlarge" style="width:12%;">
    <div class="w3-display-container">
        {$this->getItemsBlocs()}
    </div>
</div>
</body></html>
R;
        return $page;
    }

    private function getScriptResults()
    {
        $exec = "{ 'nginx':  {'name':'Nginx','res':'ok'},     'fpm':    {'name':'Php-fpm','res':'ok'},    
        'varnish':{'name':'Varnish','res':0},     'mysql':  {'name':'MySql','res':'ok','host':'10.21.51.3'},     
        'mongo':  {'name':'MongoDb','res':'ok','host':'db:27017'},     'elastic':{'name':'Elastic Search','res':'ok','host':'es:9200'} } ";
        $exec = exec(self::COMMAND);
        
        $r =json_decode(str_replace("'",'"',$exec));
        
        return $r;
    }

    private function getItemsBlocs()
    {
        $results = $this->getScriptResults();

        $template = '<section class="blocs"><h3>9</h3>';
        foreach($results as $result) {
            $template .= $this->getItemBloc($result);
        }
        $template .= '</section>';
        
        return $template;
    }
    // docker run -p 5010:5000 elastichq/elasticsearch-hq -e HQ_DEFAULT_URL='http://10.21.51.4:9200'
    private function getItemBloc($result)
    {
        $border_color = $result->res === 'ok' ? ' w3-border-green  w3-pale-green ' : ' w3-border-red  w3-pale-red ';
        $color = $result->res === 'ok' ? ' ' : ' w3-text-red ';
        $bloc = '
            <section class="bloc w3-card-4 w3-panel w3-border w3-round-xlarge w3-leftbar w3-rightbar '.$border_color.'">
                <div class="'.$color.'" style="font-weight:bold">'.$result->name.'</div>
                <div style="font-style:italic">'.($result->host??'').'</div>
            </section>
        ';
        return $bloc;
    }
}