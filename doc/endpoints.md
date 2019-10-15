## Endpoints

Este documento foi gerado automaticamente a partir da documentação de cada endpoint.\
Data da geração: 14/10/2019 04:59:49

### /posgraduacao

  * /verifica/{codpes}
    * descricao: verifica se aluno (codpes) tem matrícula ativa na pós-graduação da unidade
  * /ativos/
    * descricao: retorna todos os alunos de pós-graduação ativos na unidade
  * /programas/{codcur}
    * descricao: retorna todos os programas de pós-graduação da unidade ou quando informado o código do curso/programa retorna somente os dados do programa solicitado
  * /orientadores/{codare}
    * descricao: retorna os orientadores credenciados na área de concentração (codare) do programa de pós graduação correspondente
  * /catalogodisciplinas/{codare}(?l=completo)
    * descricao: retorna o catálogo das disciplinas pertencentes à área de concentração
  * /disciplinas_oferecimento/{codare}
    * descricao: retorna as disciplinas em oferecimento na área de concentração (codare) do programa de pós graduação correspondente
  * /areasProgramas/{codcur}
    * descricao: retorna áreas de concentração (codare) do programa de pós-graduação correspondente (codcur)

### /pessoa

  * /dump/{codpes}
    * descricao: recebe codpes e retorna todos campos da tabela Pessoa para o codpes em questão
  * /nome/?q={nome}
    * descricao: recebe uma string nome e retorna os resultados para a tabela Pessoa
  * /docentes
    * descricao: retorna todos os docentes ativos na unidade
  * /servidores
    * descricao: retorna todos os funcionários ativos na unidade
  * /estagiarios
    * descricao: retorna todos os estagiários ativos na unidade

### /bempatrimoniado

  * /dump/{numpat}
    * descricao: retorna todos campos da tabela bempatrimoniado

