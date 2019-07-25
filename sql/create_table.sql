CREATE TABLE plan(
    id SERIAL,
    plan_title VARCHAR(255),
    start_time_h INTEGER NOT NULL,
    start_time_m INTEGER NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE place(
    id SERIAL,
    plan_id INTEGER,
    index INTEGER NOT NULL,
    place VARCHAR(255) NOT NULL,
    time INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(plan_id) REFERENCES plan(id)
);