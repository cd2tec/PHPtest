CREATE TABLE `enderecos_pesquisados` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT not null,
    `cep` int(11) not null,
    `logradouro` varchar(250) not null,
    `complemento` varchar(250) not null,
    `bairro` varchar(100) not null,
    `localidade` varchar(100) not null,
    `uf` varchar(2) not null,
    `ibge` int(11) not null,
    `gia` varchar(100) not null,
    `ddd` int(2) not null,
    `siafi` int(10) not null
);