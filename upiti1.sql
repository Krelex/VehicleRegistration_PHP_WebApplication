select
distinct
kor.korisnik_id,
concat(kor.ime,' ',kor.prezime) as 'Korisnik',
(select count(*) from prekrsaj p join vozilo vz on p.vozilo_id = vz.vozilo_id where vz.korisnik_id = kor.korisnik_id and p.`status`='P') as 'Placenih',
(select count(*) from prekrsaj p join vozilo vz on p.vozilo_id = vz.vozilo_id where vz.korisnik_id = kor.korisnik_id and p.`status`='N') as 'Neplacenih'
from prekrsaj pr
join vozilo v
on pr.vozilo_id = v.vozilo_id
join korisnik kor
on v.korisnik_id = kor.korisnik_id
where pr.kategorija_id in (select kategorija_id from kategorija where moderator_id=2)
and kor.korisnik_id = 5
order by kor.korisnik_id;