CREATE DATABASE bdviajes; 

CREATE TABLE persona (
nombre varchar(150),
apellido varchar(150),
nrodoc varchar(15) PRIMARY KEY,
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    FOREIGN KEY (rnombre) REFERENCES persona (nombre),
    FOREIGN KEY (rapellido) REFERENCES persona (apellido),
    FOREIGN KEY (rnrodoc) REFERENCES persona (nrodoc),
    PRIMARY KEY (rnumeroempleado)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pdocumento varchar(15),
    pnombre varchar(150), 
    papellido varchar(150), 
	ptelefono int, 
	idviaje bigint,
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje),
    FOREIGN KEY (pnombre) REFERENCES persona (nombre),
    FOREIGN KEY (papellido) REFERENCES persona (apellido),
    FOREIGN KEY (pdocumento) REFERENCES persona (nrodoc),
	    PRIMARY KEY (pdocumento)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
