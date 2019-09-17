CREATE TABLE plan(
    id SERIAL,
    plan_title VARCHAR(255),
    start_time_h INTEGER NOT NULL,
    start_time_m INTEGER NOT NULL,
    user_id INTEGER,
    created_at TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY(user_id) REFERENCES users(id)
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