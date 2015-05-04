<?Php

/*
 *  by Henrique Kieckbusch
 *
 * just send this .php file into a PHP server and open it.
 *
 * */

class chromaSquad{
	var $dados;
	function chromaSquad(){
		$this->dados = array();
	}
	function salvoParaArray( $conteudo ){
		$t = explode('#',$conteudo);
		foreach($t as $_t){
			$t2 = explode('!',$_t);
            if(count($t2)>1)$this->dados[ $this->_c( $t2[0] )] = $this->_c($t2[1] );
        }
	}
	function _c($a, $d = -1){
        for($a = str_split( utf8_decode($a) ), $r='',$i=0;$i<count($a);$i++)  $r .= chr( ord($a[$i]) + ( $d*ord( substr(str_rot13('vOSnn95Lo8C1fDPMYKIUvrLcYZ8G699o'), $i%32, 1) ) ) );
		return $d > 0 ? utf8_encode($r) : $r;
	}

    function postParaArquivo( $a ){
        foreach($a as $i=>$j) echo $this->_c($i,1).'!'.$this->_c($j,1).'#';
    }
}

$cabecalho = '
    <style type="text/css">*{font-family:verdana; margin:12px;}input[type="text"]{width:400px; border:1px blue solid; padding:4px;}</style>
    <form method="post" enctype="multipart/form-data">
';

if( count($_FILES) > 0 && $_FILES['arq']['size'] > 0) {
    echo $cabecalho;
    $t = new chromaSquad();
    $t->salvoParaArray( file_get_contents( $_FILES['arq']['tmp_name'] ) );
    if(count($t->dados) < 3) die('Wrong file.');
    echo 'Above you have your save file data, most of values are advanced. Maybe you just want to change the money? <br/><br/> Well... After that, click in the button and save the new file in the same folder. <hr/><br/><br/>';
    foreach($t->dados as $i=>$k) echo $i.'<br/> <input type="text" name="'.$i.'" value="'.$k.'" /> <br/>';

    echo '<hr/> <input type="submit" name="submit" value="Download edited file" /> ';
}else{
    if( count($_POST)>2 ){
        unset($_POST['submit']);
        $t = new chromaSquad();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=new_save.csqd');
        header('Content-Transfer-Encoding: binary');
        $t->postParaArquivo( $_POST );
        die();
    }
    echo $cabecalho;
?>
    Please, send above the *.csqd  file of your game. You find it in the "savedGames" directory of Chroma Squad Game. <br/>
    <input type="file" name="arq" /> <br/><br/>
    <input type="submit" value="send it" />
    <br/>
<?Php
}
echo '</form>';
