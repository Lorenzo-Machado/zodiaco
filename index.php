<?php include('layouts/header.php'); ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="text-white mb-0">descubra seu signo </h2>
            </div>
            <div class="card-body">
                <p class="text-center text-muted mb-4">
                    digite sua data de nascimento
                </p>
                
                <form id="signo-form" method="POST" action="show_zodiac_sign.php">
                    <div class="mb-4">
                        <label for="data_nascimento" class="form-label">
                            <strong>data de Nascimento</strong>
                        </label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="data_nascimento" 
                            name="data_nascimento" 
                            required
                            min="1900-01-01"
                            max="<?php echo date('Y-m-d'); ?>"
                        >
                        <div class="form-text text-muted">
                            insira sua data de nascimento para consultar seu signo
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        consultar Signo
                    </button>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-white-50">
                baseado no zodíaco ocidental
            </small>
        </div>
    </div>
</div>

<?php include('layouts/footer.php'); ?>