<?php 
include('layouts/header.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['data_nascimento'])) {
    header('Location: index.php');
    exit;
}

$data_nascimento = $_POST['data_nascimento'];
$signos = simplexml_load_file("signos.xml");

if ($signos === false) {
    echo '<div class="alert alert-danger">erro carregando dados</div>';
    include('layouts/footer.php');
    exit;
}


function converterDataParaAno($data, $ano) {
    $partes = explode('/', $data);
    if (count($partes) == 2) {
        return strtotime("{$ano}-{$partes[1]}-{$partes[0]}");
    }
    return false;
}


$timestamp_nascimento = strtotime($data_nascimento);
if ($timestamp_nascimento === false) {
    echo '<div class="alert alert-danger">data de nascimento invalida</div>';
    include('layouts/footer.php');
    exit;
}

$ano_nascimento = date('Y', $timestamp_nascimento);
$mes_nascimento = date('m', $timestamp_nascimento);
$dia_nascimento = date('d', $timestamp_nascimento);
$data_usuario = strtotime("{$ano_nascimento}-{$mes_nascimento}-{$dia_nascimento}");
$signo_encontrado = null;

foreach ($signos as $signo) {
    $data_inicio_str = (string)$signo->dataInicio;
    $data_fim_str = (string)$signo->dataFim;
    
    $data_inicio = converterDataParaAno($data_inicio_str, $ano_nascimento);
    $data_fim = converterDataParaAno($data_fim_str, $ano_nascimento);
    
    if ($data_inicio === false || $data_fim === false) {
        continue;
    }
    

    if ($data_inicio > $data_fim) {
        
        if (($data_usuario >= $data_inicio && $data_usuario <= strtotime("{$ano_nascimento}-12-31")) ||
            ($data_usuario >= strtotime("{$ano_nascimento}-01-01") && $data_usuario <= $data_fim)) {
            $signo_encontrado = $signo;
            break;
        }
    } else {
   
        if ($data_usuario >= $data_inicio && $data_usuario <= $data_fim) {
            $signo_encontrado = $signo;
            break;
        }
    }
}


if ($signo_encontrado === null) {
    $signo_encontrado = $signos[0]; 
}
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="text-white mb-0">
                    seu Signo é <?php echo htmlspecialchars($signo_encontrado->signoNome); ?> 
                </h2>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="signo-info">
                        <h4 class="text-primary mb-3">
                            <?php echo htmlspecialchars($signo_encontrado->signoNome); ?>
                        </h4>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p>
                                    <strong>periodo:</strong><br>
                                    <?php echo htmlspecialchars($signo_encontrado->dataInicio); ?> a 
                                    <?php echo htmlspecialchars($signo_encontrado->dataFim); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>data de naascimento:</strong><br>
                                    <?php echo date('d/m/Y', strtotime($data_nascimento)); ?>
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="mt-3">
                            <p>
                                <strong>características do signo</strong><br>
                                <?php echo htmlspecialchars($signo_encontrado->descricao); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-secondary">
                        nova Consulta
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-white-50">
                A astrologia é uma ferramenta de autoconhecimento • Divirta-se!
            </small>
        </div>
    </div>
</div>

<?php include('layouts/footer.php'); ?>