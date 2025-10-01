┌──────────────────────────────────────────────────────────────────────┐
│                  🟩 AGENDA 2025                        │
│         Sistema de Gestão de Contatos         │
└──────────────────────────────────────────────────────────────────────┘

🔐 AUTENTICAÇÃO E CONTROLE DE ACESSO
├── Perfis: Usuário | Administrador | Suporte | Desenvolvimento
├── Administrador → gerencia apenas "Usuário"
├── Suporte → gerencia TODOS os perfis (inclusive Administradores)
├── Desenvolvimento e Usuário → acesso apenas à consulta
└── Login com sessão e proteção de rotas

📱 RESPONSIVIDADE TOTAL
├── Layout adaptável para celular, tablet e desktop
├── Tabelas viram cards em telas menores
├── Modais ajustáveis
└── Footer empilhado em dispositivos móveis

🔎 BUSCA EM TEMPO REAL
├── Localize qualquer vara por: nome, contato, e-mail, endereço
├── Filtro instantâneo sem recarregar a página
└── Suporte a múltiplos termos e caracteres acentuados

📝 GERENCIAMENTO DE CONTATOS
├── Adicionar, Editar (em modal), Excluir (com confirmação)
├── Campos: Nome da Vara, Contato (múltiplos números), E-mail, Endereço, Link do Balcão Virtual
├── Validação de campos obrigatórios
└── Logs de alterações futuros (opcional)

📤📥 IMPORTAÇÃO E EXPORTAÇÃO
├── Exportar todos os contatos em .TXT (formato legível)
├── Importar .TXT no mesmo formato (parser automático)
└── Suporte a grandes volumes de dados (500+ registros)

👥 GERENCIAMENTO DE USUÁRIOS (com permissões escalonadas)
├── Apenas Administrador e Suporte veem o menu
├── Edição de perfil respeita hierarquia:
│   └── Administrador → só pode editar “Usuário”
│   └── Suporte → edita qualquer perfil
└── Prevenção de alterações indevidas via validação no backend

📊 DASHBOARD COMPLETO
├── Lista todas as varas com dados estruturados
├── Ações rápidas: Editar (✏️) e Excluir (🗑️) em popup
├── Links clicáveis para Balcão Virtual
└── Estatísticas futuras (ex: total de varas por região)

🏛️ DADOS COMPLETOS DO TJCE
├── +500 registros importados do PDF oficial (atualizado em 17/08/2024)
├── Inclui:
│   ├── Todas as Varas Cíveis, Criminais, de Família, Fazenda, Infância, Júri
│   ├── Juizados Especiais (Cíveis e Criminais)
│   ├── Centros Judiciários (CEJUSCs)
│   ├── Comarcas do Interior (Acaraú, Sobral, Juazeiro, Crateús, etc.)
│   ├── Núcleos Regionais, GADES, Secretarias, Ouvidoria
└── Coluna “contato” suporta múltiplos números e rótulos (ex: WhatsApp, Fixo, Celular)

🎨 DESIGN INSTITUCIONAL
├── Gradiente verde → branco (padrão CGD/TJCE)
├── Logo do Governo do Ceará na Splash Screen
├── Footer institucional completo com:
│   ├── Endereço 
│   ├── Horário de atendimento
│   ├── Canais de contato
│   └── Copyright 2017–2025
└── Estilo limpo, acessível e profissional

⚙️ TECNOLOGIAS UTILIZADAS
├── Backend: PHP 8.x + MySQL
├── Frontend: HTML5, CSS3, JavaScript (modais, busca dinâmica)
├── Banco: MySQL (tabela `varas` e `usuarios`)
├── Hospedagem: Servidor Apache (XAMPP/WAMP/LAMP)
└── Segurança: Prepared Statements, Validação de Sessão, Controle de Permissões

📂 ARQUITETURA DO PROJETO
├── index.php → Splash Screen
├── login.php / register.php → Autenticação
├── dashboard.php → Listagem + Busca + Ações
├── add_agenda.php / edit_agenda.php → CRUD de Varas
├── delete_agenda.php → Exclusão segura
├── export_agenda.php / import_agenda.php → TXT
├── gerenciar_usuarios.php / editar_usuario.php → Controle de acesso
├── style.css / script.js → Estilo e interatividade
└── config.php → Conexão com banco de dados

🛡️ SEGURANÇA IMPLEMENTADA
├── Proteção contra SQL Injection (PDO)
├── Validação de sessão em todas as páginas
├── Controle de permissões por perfil
├── Alertas amigáveis de erro
└── Confirmação de exclusão via modal (não mais alert() nativo)

📈 PRÓXIMAS EVOLUÇÕES (OPCIONAIS)
├── Exportar para Excel, PDF ou JSON
├── Dashboard com gráficos (Chart.js)
├── Logs de auditoria (quem editou o quê e quando)
├── Notificações em tempo real
├── Dark Mode
└── Integração com API do TJCE para atualização automática