CREATE TABLE IF NOT EXISTS tarefas (
    id         SERIAL       PRIMARY KEY,
    titulo     VARCHAR(255) NOT NULL,
    descricao  TEXT,
    status     VARCHAR(20)  NOT NULL DEFAULT 'Pendente',
    prioridade VARCHAR(20)  NOT NULL DEFAULT 'Media',
    criado_em  TIMESTAMP    NOT NULL DEFAULT NOW()
    );