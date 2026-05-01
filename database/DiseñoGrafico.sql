CREATE TABLE materiales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    precio_por_unidad DECIMAL(10,2) NOT NULL CHECK (precio_por_unidad >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trabajos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL CHECK (precio_venta >= 0),
    fecha DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trabajo_materiales (
    id SERIAL PRIMARY KEY,
    trabajo_id INTEGER NOT NULL REFERENCES trabajos(id) ON DELETE CASCADE,
    material_id INTEGER NOT NULL REFERENCES materiales(id),

    cantidad_usada DECIMAL(10,2) NOT NULL CHECK (cantidad_usada > 0),

    -- precio en el momento del uso (histórico)
    precio_unitario DECIMAL(10,2) NOT NULL CHECK (precio_unitario >= 0),

    -- costo calculado (útil para rendimiento)
    costo_calculado DECIMAL(10,2) GENERATED ALWAYS AS (cantidad_usada * precio_unitario) STORED,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índice para búsquedas rápidas por trabajo
CREATE INDEX idx_trabajo_materiales_trabajo_id 
ON trabajo_materiales(trabajo_id);


ALTER TABLE trabajos ADD eliminado BOOLEAN DEFAULT FALSE;
