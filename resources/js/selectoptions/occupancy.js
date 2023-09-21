const occupancy = {
    RESIDENTIAL: {
        subtype: [
            "HOTEL",
            "DORMITORY",
            "APARTMENT",
            "LODGING HOUSE",
            "SINGLE TWO FAMILY DWELLING",
            "BOARDING HOUSE",
            "CONDOMINIUM",
            "PENSION HOUSE",
        ],
    },
    ASSEMBLY: {
        subtype: [
            "AIRPORTS",
            "PIERS WHARVES",
            "COLISEUM",
            "THEATERS",
            "RESORTS RESTAURANTS",
        ],
    },
    "HEALTH CARE": {
        subtype: ["HC PRIVATE", "HC PUBLIC"],
    },
    EDUCATIONAL: {
        subtype: [
            "PRIVATE ELEMENTARY",
            "PRIVATE HIGH SCHOOL",
            "PRIVATE COLLEGE",
            "PRIVATE TECHNICAL VOCATIONAL",
            "PRIVATE UNIVERSITY",
            "PRIVATE MEDICAL SCHOOL",
            "PRIVATE INTERNATIONAL SCHOOL",
            "PRIVATE SPECIAL SCHOOL",
            "PRIVATE OTHERS",
            "PUBLIC NURSERY",
            "PUBLIC ELEMENTARY",
            "PUBLIC HIGH SCHOOL",
            "PUBLIC COLLEGE",
            "PUBLIC TECHNICAL VOCATIONAL",
            "PUBLIC UNIVERSITY",
            "PUBLIC MEDICAL SCHOOL",
            "PUBLIC INTERNATIONAL SCHOOL",
            "PUBLIC SPECIAL SCHOOL",
            "PUBLIC OTHERS",
        ],
    },
    MERCANTILE: {
        subtype: [
            "MALLS DEPARTMENT STORE",
            "GASOLINE STATION",
            "LPG REFILLING STATION",
        ],
    },
    "DETENTION AND CORRECTIONAL": {
        subtype: ["DC PRIVATE", "DC PUBLIC"],
    },
    INDUSTRIAL: {
        subtype: [
            "FACTORIES",
            "LAUNDRIES",
            "PUMPING STATION",
            "POWER PLANTS",
            "SAW MILLS",
        ],
    },
    BUSINESS: {
        subtype: [
            "GOVERNMENT CORP PUBLIC BLDG",
            "BARANGAY HALL",
            "TRADING SERVICES",
            "OFFICES",
        ],
    },
    STORAGE: {
        subtype: ["DEPOT", "WAREHOUSE"],
    },
    OTHERS: {
        subtype: ["AMBULANT", "VEHICULAR", "OTHER"],
    },
};

export default occupancy;
