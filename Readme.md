#MARATHON 2019 - 2020**

___
___
___
___

## Installation

### copy a new .env.local => cp .env .env.local


**Change in env.local** *db_user, db_password, db_name by your configuration*


```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

##### then

```
./install
```

___
___
___
___

## Launch Server Symfony local
```
./symfony server:start -d
```

## kill Server Symfony local
```
./symfony server:stop
```


___
___
___
___

## Update CSS or/and JS

### Avec yarn

##### Dev

```
yarn run encore dev
```

##### Prod

```
yarn run encore production
```

### Avec npm

##### Dev
```
npm run dev
```

##### Prod

```
npm run build
```



___
___
___

## Utilisateur

| Username   |      Password      |  Role |
|:----------|:-------------|:------|
| ZimZim |  ZimZim | ROLE_ADMIN |
| Fred |   Fred   |   ROLE_ADMIN |
| Gilles |   Gilles   |   ROLE_USER |
| Sebastien |   Sebastien   |   ROLE_USER |


___
___
___


## For upload File ( SysAdmin Only )
```
chown -R www-data:www-data public/images/users
chown -R www-data:www-data public/video/series
```


___
___
___



## Enjoy and team play




___
___
___


___
___
___


___
___
___



