SELECT
    n.nid AS nid,
    n.title AS title

FROM node AS n

WHERE
    n.type = 'hsc_news_call_out'
    AND n.status = 1