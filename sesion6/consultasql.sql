/* Se ha utilizado distinct para que no muestre registros duplicados, así mismo
se ha utilizado order by para que muestre el resultado ordenado alfabeticamente
por el nombre de la ciudad*/
SELECT distinct network, city_name, latitude, longitude
FROM cities_locations, cities_blocks_ip4
WHERE network BETWEEN '83.43.1.0/25' AND '83.43.204.0/24'
ORDER BY city_name;
