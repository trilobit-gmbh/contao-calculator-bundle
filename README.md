Calculator Bundle
=================

Das Calculator Bundle ermöglicht es durch Verwendung eines Insert-Tags eine Vielzahl an Operationen durchzuführen.
Mögliche Operationen währen arithmetische Operationen, mit denen es möglich ist, einfache bis verschachtelte Berechnungen
auszuführen. Durch die Verwendung der Symfony Expression Language ist es außerdem möglich, Variablen zu definieren 
und diese wiederum für Operationen zu verwenden. Diese Variablen können entweder in einer `config.yml` definiert werden dann
muss diese mit dem Array `parameters` anfangen und unter `www/app/config` ihrer Webseite abgelegt werden. Oder sie fügen 
die Variablen in die `parameters.yml` ihrer Webseite ein, so wie im Beispiel unten.

Aufbau
------

Der Insert-Tag wird durch die Abkürzung "calc" definiert und mit zwei Doppelpunkten von der Operation getrennt. 
Dies könnte zum Beispiel so aussehen: `{{calc::5 + 7}}`, 
mit Variablen so: `{{calc::Länge * Breite}}`
oder so `{{calc::Rechteck['Länge'] * Rechteck['Breite']}}`.

Mit Datum rechnen
------

Um mit Datum rechnen zu können müssen die Date-InsertTags mit `[`-Klammern geschrieben werden:

Die trilobit GmbH gibt es jetzt seit `{{calc::[[date::Y]] - 1999}}` Jahren.

Die trilobit GmbH ist jetzt `{{calc::(([[date::Y]]*12+[[date::m]])-(1999*12+3)-(([[date::Y]]*12+[[date::m]])-(1999*12+3))%12)/12}}` Jahre und `{{calc::(([[date::Y]]*12+[[date::m]])-(1999*12+3))%12}}` Monate alt.

Calculator bundle
=================

The Calculator Bundle allows you to perform a variety of operations by using an insert-tag. Possible operations 
could be arithmetical operations with which it is possible to do simple to complex calculations. By using the 
Symfony Expression Language it is also possible to define variables and to use these for operations. 
These variables can either be defined in a `config.yml` but then they must start with the array `parameters` and be 
stored in `www/app/config` of your website. Or you add the variables to your `parameters.yml` of your website, as in the example below.


Structure
---------

The insert tag is defined by the abbreviation "calc" and separated from the operation with two colons.
For example, this could look like this: `{{calc::5 + 7}}`,
with variables like this: `{{calc::length * width}}`
or like this `{{calc::rectangle['length'] * rectangle['width']}}`.


How to use
----------

Add parameters to your `parameters.yml` or `config.yml`:
```yaml
trilobit:
    calculator:
        vars:
            trilobit: 123
            contao:
                partner:
                    - type: 'Webdesign'
                      test: 42
                      referenzen:
                          - 'du'
                          - 'ich'
                          - 'wir'
                    - type: 'Progammierung'
                      test: 2
                    - type: 'Schulung'
                      test: 3
            github: 'trilobit-gmbh'
```


| Insert-Tag | Ergebnis / Ausgabe |
| ------------------ | ------------------ |
| `{{calc::5+7}}` | 12 |
| `{{calc::5+7*10}}` | 75 |
| `{{calc::trilobit}}` | 123 |
| `{{calc::trilobit*3}}` | 369 |
| `{{calc::contao['partner'][0]['type']}}` | Webdesign |
| `{{calc::contao['partner'][0]['test']}}` | 42 |
| `{{calc::contao['partner'][0]['referenzen'][0]}}` | du |
| `{{calc::contao['partner'][0]['test'] + trilobit}}` | 165 |
| `{{calc::github}}` | trilobit-gmbh |


Installation
------------

Install the extension via composer: [trilobit-gmbh/contao-calculator-bundle](https://packagist.org/packages/trilobit-gmbh/contao-calculator-bundle).


Compatibility
-------------

- Contao version ~4.9
- PHP >= 7.3
