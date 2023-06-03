function populateSelect(selectElement,options){
    options.forEach(option => {
        const optionEl = document.createElement("option")
        optionEl.setAttribute("value",option)
        optionEl.innerHTML = option
        selectElement.appendChild(optionEl)
    });
}
function populateNatueOfPaymentSelect(selectElement,options){
    options.forEach(option => {
        const optionEl = document.createElement("option")
        const natureOfPayment = `${option.DESCRIPTION} - ${option.NATURE_PAYMENT} - ${option.CODE}`
        optionEl.setAttribute("value",natureOfPayment)
        optionEl.innerHTML = natureOfPayment
        selectElement.appendChild(optionEl)
    });
}

const natureOfPayments = [
        {
            DESCRIPTION: "FCCT",
            NATURE_PAYMENT: "FIRE CODE CONSTRUCTION TAX",
            CODE: "BFP-01"
        },
        {
            DESCRIPTION: "FCRT",
            NATURE_PAYMENT: "FIRE CODE REALTY TAX",
            CODE: "BFP-02"
        },
        {
            DESCRIPTION: "FCPret",
            NATURE_PAYMENT: "FIRE CODE PREMIUM TAX",
            CODE: "BFP-03"
        },
        {
            DESCRIPTION: "FCProt",
            NATURE_PAYMENT: "FIRE CODE PROCEEDS TAX",
            CODE: "BFP-04"
        },
        {
            DESCRIPTION: "FCST",
            NATURE_PAYMENT: "FIRE CODE SALES TAX",
            CODE: "BFP-05"
        },
        {
            DESCRIPTION: "FSIF(NBP)",
            NATURE_PAYMENT: "FIRE SAFETY INSPECTION FEE",
            CODE: "BFP-06"
        },
        {
            DESCRIPTION: "FSIF(RBP)",
            NATURE_PAYMENT: "FIRE SAFETY INSPECTION FEE",
            CODE: "BFP-06"
        },
        {
            DESCRIPTION: "FSIF(OCC)",
            NATURE_PAYMENT: "FIRE SAFETY INSPECTION FEE",
            CODE: "BFP-06"
        },
        {
            DESCRIPTION: "FSIF(ACCREDITATION)",
            NATURE_PAYMENT: "FIRE SAFETY INSPECTION FEE",
            CODE: "BFP-06"
        },
        {
            DESCRIPTION: "STO",
            NATURE_PAYMENT: "STORAGE CLEARANCE FEE",
            CODE: "BFP-07"
        },
        {
            DESCRIPTION: "CON",
            NATURE_PAYMENT: "CONVEYANCE CLEARANCE FEE",
            CODE: "BFP-08"
        },
        {
            DESCRIPTION: "INST",
            NATURE_PAYMENT: "INSTALLATION CLEARANCE FEE",
            CODE: "BFP-09"
        },
        {
            DESCRIPTION: "FCAF",
            NATURE_PAYMENT: "FIRE CODE ADMINISTRATIVE FINES",
            CODE: "BFP-11"
        },
        {
            DESCRIPTION: "OTHERS(FD)",
            NATURE_PAYMENT: "OTHERS (FIRE DRILL)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(FWD)",
            NATURE_PAYMENT: "OTHERS (FIREWORKS DISPLAY)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(HW)",
            NATURE_PAYMENT: "OTHERS (HOTWORKS)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(FG)",
            NATURE_PAYMENT: "OTHERS (FOGGING)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(L/U)",
            NATURE_PAYMENT: "OTHERS (LOADING/UNLOADING)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(SF)",
            NATURE_PAYMENT: "OTHERS (STANDBY FIRE TRUCK)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(FC)",
            NATURE_PAYMENT: "OTHERS (FIRE CERTIFICATE)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "OTHERS(A/CTC)",
            NATURE_PAYMENT: "OTHERS (AUTHENTICATION/CTC)",
            CODE: "BFP-10"
        },
        {
            DESCRIPTION: "FCCT/Hotworks",
            NATURE_PAYMENT: "FCCT/Hotworks",
            CODE: "BFP-01/10"
        }
]

const subtype = [
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "HOTEL",
        ABBREVIATE: "HOTEL"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "DORMITORY",
        ABBREVIATE: "DORM"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "APARTMENT",
        ABBREVIATE: "APT"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "LODGING HOUSE",
        ABBREVIATE: "LH"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "SINGLE TWO FAMILY DWELLING",
        ABBREVIATE: "STFD"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "BOARDING HOUSE",
        ABBREVIATE: "BH"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "CONDOMINIUM",
        ABBREVIATE: "CONDO"
    },
    {
        OCCUPANCY_TYPE: "RESIDENTIAL",
        SUBTYPE: "PENSION HOUSE",
        ABBREVIATE: "PH"
    },
    {
        OCCUPANCY_TYPE: "ASSEMBLY",
        SUBTYPE: "AIRPORTS",
        ABBREVIATE: "AP"
    },
    {
        OCCUPANCY_TYPE: "ASSEMBLY",
        SUBTYPE: "PIERS WHARVES",
        ABBREVIATE: "PW"
    },
    {
        OCCUPANCY_TYPE: "ASSEMBLY",
        SUBTYPE: "COLISEUM",
        ABBREVIATE: "COL"
    },
    {
        OCCUPANCY_TYPE: "ASSEMBLY",
        SUBTYPE: "THEATERS",
        ABBREVIATE: "TH"
    },
    {
        OCCUPANCY_TYPE: "ASSEMBLY",
        SUBTYPE: "RESORTS RESTAURANTS",
        ABBREVIATE: "RR"
    },
    {
        OCCUPANCY_TYPE: "HEALTH CARE",
        SUBTYPE: "HC PRIVATE",
        ABBREVIATE: "HPR"
    },
    {
        OCCUPANCY_TYPE: "HEALTH CARE",
        SUBTYPE: "HC PUBLIC",
        ABBREVIATE: "HPU"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE NURSERY",
        ABBREVIATE: "EPRN"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE ELEMENTARY",
        ABBREVIATE: "EPRE"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE HIGH SCHOOL",
        ABBREVIATE: "EPRH"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE COLLEGE",
        ABBREVIATE: "EPRC"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE TECHNICAL VOCATIONAL",
        ABBREVIATE: "EPRTV"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE UNIVERSITY",
        ABBREVIATE: "EPRU"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE MEDICAL SCHOOL",
        ABBREVIATE: "EPRMS"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE INTERNATIONAL SCHOOL",
        ABBREVIATE: "EPRIS"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE SPECIAL SCHOOL",
        ABBREVIATE: "EPRSS"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PRIVATE OTHERS",
        ABBREVIATE: "EPRO"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC NURSERY",
        ABBREVIATE: "EPUN"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC ELEMENTARY",
        ABBREVIATE: "EPUE"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC HIGH SCHOOL",
        ABBREVIATE: "EPUH"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC COLLEGE",
        ABBREVIATE: "EPUC"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC TECHNICAL VOCATIONAL",
        ABBREVIATE: "EPUTV"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC UNIVERSITY",
        ABBREVIATE: "EPUU"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC MEDICAL SCHOOL",
        ABBREVIATE: "EPUMS"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC INTERNATIONAL SCHOOL",
        ABBREVIATE: "EPUIS"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC SPECIAL SCHOOL",
        ABBREVIATE: "EPUSC"
    },
    {
        OCCUPANCY_TYPE: "EDUCATIONAL",
        SUBTYPE: "PUBLIC OTHERS",
        ABBREVIATE: "EPUO"
    },
    {
        OCCUPANCY_TYPE: "MERCANTILE",
        SUBTYPE: "MALLS DEPARTMENT STORE",
        ABBREVIATE: "MMD"
    },
    {
        OCCUPANCY_TYPE: "MERCANTILE",
        SUBTYPE: "GASOLINE STATION",
        ABBREVIATE: "MGS"
    },
    {
        OCCUPANCY_TYPE: "MERCANTILE",
        SUBTYPE: "LPG REFILLING STATION",
        ABBREVIATE: "MLPG"
    },
    {
        OCCUPANCY_TYPE: "DETENTION AND CORRECTIONAL",
        SUBTYPE: "DC PRIVATE",
        ABBREVIATE: "DCPR"
    },
    {
        OCCUPANCY_TYPE: "DETENTION AND CORRECTIONAL",
        SUBTYPE: "DC PUBLIC",
        ABBREVIATE: "DCPU"
    },
    {
        OCCUPANCY_TYPE: "INDUSTRIAL",
        SUBTYPE: "FACTORIES",
        ABBREVIATE: "IFAC"
    },
    {
        OCCUPANCY_TYPE: "INDUSTRIAL",
        SUBTYPE: "LAUNDRIES",
        ABBREVIATE: "ILAU"
    },
    {
        OCCUPANCY_TYPE: "INDUSTRIAL",
        SUBTYPE: "PUMPING STATION",
        ABBREVIATE: "IPUS"
    },
    {
        OCCUPANCY_TYPE: "INDUSTRIAL",
        SUBTYPE: "POWER PLANTS",
        ABBREVIATE: "IPOW"
    },
    {
        OCCUPANCY_TYPE: "INDUSTRIAL",
        SUBTYPE: "SAW MILLS",
        ABBREVIATE: "ISAW"
    },
    {
        OCCUPANCY_TYPE: "BUSINESS",
        SUBTYPE: "GOVERNMENT CORP PUBLIC BLDG",
        ABBREVIATE: "BGOV"
    },
    {
        OCCUPANCY_TYPE: "BUSINESS",
        SUBTYPE: "BARANGAY HALL",
        ABBREVIATE: "BBH"
    },
    {
        OCCUPANCY_TYPE: "BUSINESS",
        SUBTYPE: "TRADING SERVICES",
        ABBREVIATE: "BTS"
    },
    {
        OCCUPANCY_TYPE: "BUSINESS",
        SUBTYPE: "OFFICES",
        ABBREVIATE: "BOF"
    },
    {
        OCCUPANCY_TYPE: "STORAGE",
        SUBTYPE: "DEPOT",
        ABBREVIATE: "SDP"
    },
    {
        OCCUPANCY_TYPE: "STORAGE",
        SUBTYPE: "WAREHOUSE",
        ABBREVIATE: "SWH"
    },
    {
        OCCUPANCY_TYPE: "OTHERS",
        SUBTYPE: "AMBULANT",
        ABBREVIATE: "AMB"
    },
    {
        OCCUPANCY_TYPE: "OTHERS",
        SUBTYPE: "VEHICULAR",
        ABBREVIATE: "VEH"
    },
    {
        OCCUPANCY_TYPE: "OTHERS",
        SUBTYPE: "OTHER",
        ABBREVIATE: "OTH"
    }
]

const barangays = [
    "ADLAON",
    "AGSUNGOT",
    "APAS",
    "BABAG",
    "BACAYAN",
    "BANILAD",
    "BASAK SAN NICOLAS",
    "BASAK-PARDO",
    "BINALIW",
    "BONBON",
    "BUDLA-AN",
    "BUHISAN",
    "BULACAO PARDO",
    "BUOT-TAUP",
    "BUSAY",
    "CALAMBA",
    "CAMBINOCOT",
    "CAPITOL SITE",
    "CARRETA",
    "COGON PARDO",
    "COGON RAMOS",
    "DAY-AS",
    "DULJO-FATIMA",
    "GUADALUPE",
    "GUBA",
    "HIPODROMO",
    "INAYAWAN",
    "KALUBIHAN",
    "KALUNASAN",
    "KAMAGAYAN",
    "KAMPUTHAW (CAMPUTHAW)",
    "KASAMBAGAN",
    "KINASANG-AN",
    "LABANGON",
    "LAHUG",
    "LOREGA SAN MIGUEL",
    "LUSARAN",
    "LUZ",
    "MABINI",
    "MABOLO PROPER",
    "MALUBOG",
    "MAMBALING",
    "PAHINA CENTRAL",
    "PAHINA SAN NICOLAS",
    "PAMUTAN",
    "PARIAN",
    "PARIL",
    "PASIL",
    "PIT-OS",
    "POBLACION PARDO",
    "PULANGBATO",
    "PUNG-OL SIBUGAY",
    "PUNTA PRINCESA",
    "QUIOT PARDO",
    "SAMBAG I",
    "SAMBAG II",
    "SAN ANTONIO",
    "SAN JOSE",
    "SAN NICOLAS PROPER",
    "SAN ROQUE",
    "SANTA CRUZ",
    "SANTO NIÑO",
    "SAPANGDAKO",
    "SAWANG CALERO",
    "SINSIN",
    "SIRAO",
    "SUBA",
    "SUDLON I",
    "SUDLON II",
    "T. PADILLA",
    "TABUNAN",
    "TAGBA-O",
    "TALAMBAN",
    "TAPTAP",
    "TEJERO",
    "TINAGO",
    "TISA",
    "TOONG",
    "ZAPATERA"
  ];

const buildingType = [
    "SMALL",
    "MEDIUM",
    "LARGE",
    "HIGH RISE"
]

const occupancy = [
    "RESIDENTIAL",
    "ASSEMBLY",
    "HEALTH CARE",
    "EDUCATIONAL",
    "MERCANTILE",
    "DETENTION AND CORRECTIONAL",
    "INDUSTRIAL",
    "BUSINESS",
    "STORAGE",
    "OTHERS"
]

const stations = [
    'CCSF','CBP','GUADALUPE','LABANGON','LAHUG','MABOLO','PAHINA CENTRAL','PARDO','PARI-AN','SAN NICOLAS','TALAMBAN'
];

const issuances = [
    'THE PURPOSE OF SECURING BUSINESS PERMIT',
    'NEW BUSINESS PERMIT',
    'OCCUPANCY PERMIT',
    'RENEWAL OF BUSINESS PERMIT',
    'RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION',
    'RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION',
    'PEZA OCCUPANCY PERMIT',
    'ANNUAL INSPECTION OF PEZA CERTIFICATE'
];

const regStatus = [
    'NEW',
    'RENEWAL',
    'OCCUPANCY',
    'BUILDING PERMIT',
    'ACCREDITATION'
];


