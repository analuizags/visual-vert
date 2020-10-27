# Visual-vert
Sistema de visualização de informações acerca da pesquisa sobre verticalização de ensino do IF Goiano. Principal objetivo é deixar a sociedade a par dos números da verticalização de cada *campi* do IF Goiano.

![Página Inicial](/public/assets/imagens/layoutInicial.png)

![](https://img.shields.io/github/issues/analuizags/visual-vert)
![](https://img.shields.io/github/forks/analuizags/visual-vert)
![](https://img.shields.io/github/stars/analuizags/visual-vert)
![](https://img.shields.io/github/license/analuizags/visual-vert)

## Configuração inicial
Para configurar a conexão com o banco de dados, é necessário criar o arquivo `config-dev.json`, adicionando credenciais válidas.
```json
{
  "database": {
    "host": "localhost",
    "user": "usuario",
    "password": "senha",
    "db": "nome_banco",
    "drive": "mysql"
  }
}
```


### Configurando o Docker 🐳

#### Iniciando os containers

```bash
$ docker-compose up -d
```

#### Após a execução dos comandos, o servidor estará disponível em [localhost/](http://localhost/)


## Tecnologia utilizadas
* jQuery 3.4
* jQuery-ui 1.12
* Chartjs 2.7
* MySQL 5.7 
* Bootstrap 4.5
* Feather Icons 4.9

---

<p align="center">
    Desenvolvido com :heart: por <b>Ana Luiza</b>
</p>
