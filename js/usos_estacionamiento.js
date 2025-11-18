const USOS_ESTACIONAMIENTO = {
    "1-Residencial -Comercio Local": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "2-Vivienda UNIFAM. Y BIFAMIL.": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "3-Vivienda Multifamiliar.": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "4-Vivienda Multifamiliar..": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "5-Unifamiliar Multifamiliar": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "6-Comercial-Tiendas-Oficinas": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "7-Oficinas administrativas": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "8-Hotel": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "9-Pensionados": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "10-Industria": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "11-Cines, Teatros, Auditorios": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "12-Institucional-Educacional": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "13-Estadios-Coliseios, etc": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "14-Serv. Comunales": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "15-Supermercados": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "16-Serv. Culturales -Centro de información": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "17-Estaciones de radio y televisión": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "18-Grifos, Gaseocentros, etc": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "19-Salud": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "20-Comercio tipo Sectorial( CS )-Tiendas": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "21-EDUCACION -EBR PRIMARIA & SECUNDARIA": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "22-EDUCACION -EBR INICIAL": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    },
    "23-EDUCACION": {
        filas: [
            { nombre: "Personal", divisor: 6, tipo: "personal" },
            { nombre: "Público", divisor: 10, tipo: "publico" },
            { nombre: "Plazas", divisor: 1, tipo: "plazas" }, // SIN valorFijo
            { nombre: "RESTO EDIF (5%)", formula: "5", tipo: "resto_porcentaje" }
        ]
    }
};