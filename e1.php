<?php
BLOCK1:begin
declare invoice1 varchar(30);
declare party1 varchar(30);
declare wh1 varchar(40);
declare gt1 varchar(30);
declare ca1 varchar(30);
declare trnum varchar(30);
declare tid1 int(255);
declare date1 DATE;
declare date2 DATE;
declare d3 DATE;
declare d2 DATE;
declare b int;
declare k int;
declare c1 cursor for select invoice,date,party,warehouse,finaltotal from oc_cobi where srflag=0 group by invoice having date <date_sub(date(now()), interval 3 day) order by date;
select count(invoice) as b  from oc_cobi where srflag=0 group by invoice;
select b;
set k:=0;
open c1;
REPEAT
fetch c1 into invoice1,date1,party1,wh1,gt1;

select invoice1,date1,party1;

select ca into ca1 from contactdetails where name=party1;

select date_add(date1,interval 3 day) as date2;
select date(now()) into d3;

select invoice1;

select concat('DCOBIR-',max(tid)+1) into trnum from distribution_salesreceipt;

select max(tid)+1 into tid1 from distribution_salesreceipt;


BLOCK2:begin

declare pr varchar(30);
declare code1 varchar(30);
declare des varchar(40);
declare qty varchar(30);
declare dis varchar(30);
declare cat1 varchar(30);
declare sunits1 varchar(30);
declare b1 int;
declare k1 int;

declare c2 cursor for select code,description,quantity,price,discountamount from oc_cobi where invoice=invoice1;
select count(*) into b1 from oc_cobi where invoice=invoice1;
set k1:=0;
open c2;
REPEAT
fetch c2 into code1,des,qty,pr,dis;
select cat into cat1 from ims_itemcodes where code=code1;
select sunits into sunits1 from ims_itemcodes where code=code1;

insert into distribution_salesreceipt(tid,trnum,date,warehouse,party,invoice,
                                     category,code,description,sunits,squantity,cquantity,
                                     finaltotal) 
values(tid1,trnum,d3,wh1,party1,invoice1,cat1,code1,des,sunits1,qty,qty,gt1
                                                       );
set k1:=k1+1;
UNTIL b1 = k1
END REPEAT;
close c2;

end BLOCK2;


update oc_cobi set srflag='1' where invoice=invoice1;
insert into ac_financialpostings(date,crdr,coacode,type,trnum,amount,venname,warehouse) values(d3,'Dr',ca1,'COBI',trnum,gt1,party1,wh1);
insert into ac_financialpostings(date,crdr,coacode,type,trnum,amount,venname,warehouse) values(d3,'Cr','SATR01','COBI',trnum,gt1,party1,wh1);

set k:=k+1;
UNTIL b = k
END REPEAT;
end BLOCK1
?>