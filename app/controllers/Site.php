<?php

namespace app\controllers;

use app\models\Crud;

class Site extends Crud
{
    public function home() 
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function redefinirSenha($nova_senha) 
    {
        $new_senha = $nova_senha;   
        require_once __DIR__ . '/../views/redefinirSenha.php';
    }

    public function loginAluno() {
        require_once __DIR__ . '/../views/loginAluno.php';
    }

    public function loginColaborador() {
        require_once __DIR__ . '/../views/loginColaborador.php';
    }

    public function loginAdm() {
        require_once __DIR__ . '/../views/loginAdm.php';
    }

    public function menu() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        }

        if ($_SESSION['codnivel_acesso'] == 4) {
            $_SESSION['error_admin'] = 'Você não tem permissão para acessar esta página!'; 
            header("Location:?router=Site/loginAdm");
            exit();
        }
        $buscarLab = $this->buscarLaboratorio();
        require_once __DIR__ . '/../views/menu.php';
    }

    public function addUsuario() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }

        $niveisAcesso = $this->getNiveisAcesso();
        require_once __DIR__ . '/../views/addUsuario.php';
    }

    public function EnviarReclamacao() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAdm");
            exit();  
        }
        if ($_SESSION['codnivel_acesso'] == 4) {
            $_SESSION['error_admin'] = 'Você não tem permissão para acessar esta página!'; 
            header("Location:?router=Site/paginaDeErro"); 
            exit();
        }

        $codLaboratorio = $_POST['codlaboratorio'];
        $situacao = $_POST['situacao'];
        $patrimonio = $_POST['patrimonio'];
        $codComputador = $_POST['codcomputador'];
        $numeroLaboratorio = $_POST['numerolaboratorio'];
        
        $buscarComponentes = $this->getComponentes();
        $detalhesReclmacoes = $this->getDetalhesReclamacao($codComputador, $codLaboratorio);
        require_once __DIR__ . '/../views/EnviarReclamacao.php';
    }

    public function relatorioManutencao() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Você não tem permissão para acessar!';           
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Você não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }
    
        $buscarLab = $this->buscarLaboratorio();
        $buscarUsuario = $this->getUsuarios();
        require_once __DIR__ . '/../views/relatorioManutencao.php';
    }
    

    public function permissoes() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4) || ($_SESSION['codnivel_acesso'] == 2)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }

        $nivelAcesso = $this->getNiveisAcesso();
        $semPermissao = $this->getUserNotPermisao();
        $buscarUsuario = $this->getAllUsers();
        require_once __DIR__ . '/../views/permissoes.php';
    }

    public function resultadoManutencao() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }
        require_once __DIR__ . '/../views/resultadoManutencao.php';
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }
        $dashboard_relatorioComp = $this->reclamacaoComp();
        $dashboard_situacao = $this->dahsboardSituacao();
        $dashboard_relatorioLab = $this->reclamacaoLab();
        $dashboard_relatorioUser = $this->manutencaoUser();

        require_once __DIR__ . '/../views/dashboard.php';
    }

    public function manutencaoLabs() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }

        $buscarComponentes = $this->getComponentes();
        $buscarLab = $this->buscarLaboratorio();
        require_once __DIR__ . '/../views/manutencaoLabs.php';
    }

    public function historicoReclamacao() {
        session_start();
        $codusuario = $_SESSION['codusuario'];

        $buscarReclamacao = $this->reclamacaoAluno($codusuario);
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 2) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }


        require_once __DIR__ . '/../views/historicoReclamacao.php';
    }

    public function editarReclamacao() {
        session_start();
        
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 2) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }
        
        $buscarComponentes = $this->getComponentes();
        require_once __DIR__ . '/../views/editarReclamacao.php';
    }

    public function relatorioComponente() {
        session_start();
        
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 2) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }

        $buscarLab = $this->buscarLaboratorio();
        $buscarUsuario = $this->getUsuarios();
        $buscarComponentes = $this->getComponentes();
    
        require_once __DIR__ . '/../views/relatorioComponente.php';
    }

    public function resultadoComponente() {
        session_start();
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/loginAdm");
            exit();
        } else if (!isset($_SESSION['codnivel_acesso']) || ($_SESSION['codnivel_acesso'] == 1) || ($_SESSION['codnivel_acesso'] == 4)) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';           
            header("Location:?router=Site/loginAluno");
            exit();
        }
        require_once __DIR__ . '/../views/resultadoComponente.php';
    }
}