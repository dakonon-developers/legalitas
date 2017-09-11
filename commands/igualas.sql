INSERT INTO igualas(id, nombre, slim_duracion, med_duracion, plus_duracion, slim, med, plus) VALUES
(1, 'empresariales', 3, 7, 10, 24000, 35000, 55000),
(2, 'estudiantiles', 3, 7, 10, 3000, 5000, 9500),
(3, 'mipymes', 3, 7, 10, 9000, 14000, 25000),
(4, 'abogados', 3, 7, 10, 24000, 35000, 55000),
(5, 'familias', 3, 7, 10, 24000, 35000, 55000)
;

INSERT INTO igualas_servicios(fk_iguala, fk_servicio) VALUES
(1, 64),
(1, 65),
(1, 67),
(2, 68),
(2, 69),
(3, 65),
(3, 66),
(3, 67),
(4, 64),
(4, 65),
(4, 66),
(4, 67),
(5, 70),
(5, 65),
(5, 66),
(5, 67)
;

-- INSERT INTO igualas(id, tipo, nombre, descripcion, slim_duracion, med_duracion, plus_duracion, slim, med, plus) VALUES
-- -- Igualas Empresariales General
-- (1, 'empresariales', 'Representación Legal', 'Representación y Asistencia en Audiencias', 3, 7, 10, 24000, 35000, 55000),
-- (2, 'empresariales', 'Consultoría', 'Consultas y Opiniones Legales', 3, 7, 10, 24000, 35000, 55000),
-- (3, 'empresariales', 'Diligencias Legales', 'Gestion Administrativo-Legal', 3, 7, 10, 24000, 35000, 55000),
-- (4, 'empresariales', 'Elaboración y Redacción', 'Elaboración y Redacción de Contratos u otros Documentos Legales', 3, 7, 10, 24000, 35000, 55000),
-- -- Igualas estudiantiles General (1)
-- (5, 'estudiantiles', 'Descarga de Documentos Modelo', 'Descarga Diversos Documentos Tipo para hacer Tus Trabajos', 3, 7, 10, 3000, 5000, 9500),
-- (6, 'estudiantiles', 'Consultoría', 'Averigua rápidamente la respuesta a tu pregunta legal', 3, 7, 10, 3000, 5000, 9500),
-- -- Igualas Mipymes - General(1)
-- (7, 'mipymes', 'Consultoría', 'Consultas y Opiniones Legales', 3, 7, 10, 9000, 14000, 25000),
-- (8, 'mipymes', 'Diligencias Legales', 'Gestion Administrativo-Legal', 3, 7, 10, 9000, 14000, 25000),
-- (9, 'mipymes', 'Elaboración y Redacción', 'Elaboracion y Redacción de Contratos u otros Documentos Legales', 3, 7, 10, 9000, 14000, 25000),
-- -- Igualas para Abogados General
-- (10, 'abogados', 'Representación Legal', 'Representación y Asistencia en Audiencias', 3, 7, 10, 24000, 35000, 55000),
-- (11, 'abogados', 'Consultoría', 'Consultas y Opiniones Legales', 3, 7, 10, 24000, 35000, 55000),
-- (12, 'abogados', 'Diligencias Legales', 'Gestion Administrativo-Legal', 3, 7, 10, 24000, 35000, 55000),
-- (13, 'abogados', 'Elaboración y Redacción', 'Elaboracion y Redacción de Contratos u otros Documentos Legales', 3, 7, 10, 24000, 35000, 55000),
-- -- Igualas para Familias - General
-- (14, 'familias', 'Representación Legal Vial y con Aseguradoras', 'Representación y Asistencia Víal y con Aseguradoras', 3, 7, 10, 24000, 35000, 55000),
-- (15, 'familias', 'Consultoría', 'Consultas y Opiniones Legales', 3, 7, 10, 24000, 35000, 55000),
-- (16, 'familias', 'Diligencias Legales', 'Gestion Administrativo-Legal', 3, 7, 10, 24000, 35000, 55000),
-- (17, 'familias', 'Elaboración y Redacción', 'Elaboracion y Redacción de Contratos u otros Documentos Legales', 3, 7, 10, 24000, 35000, 55000)
-- ;
