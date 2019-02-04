#!/usr/bin/env python
import io
import json
import os

moment_locale_directory = os.path.join(
    os.path.dirname(os.path.abspath(__file__)), "node_modules/moment/src/locale"
)

long_date_format_parts = (
    r"LT : '",
    r'LT : "',
    r"LTS : '",
    r'LTS : "',
    r"L : '",
    r'L : "',
    r"LL : '",
    r'LL : "',
    r"LLL : '",
    r'LLL : "',
    r"LLLL : '",
    r'LLLL : "',
)

locales = {}

if os.path.isdir(moment_locale_directory):
    for root, dirs, files in os.walk(moment_locale_directory):
        for file in files:
            if file.endswith(".js"):
                with io.open(os.path.join(root, file), "r", encoding="utf-8") as locale:
                    long_date_format = {}
                    for line in locale.readlines():
                        for part in long_date_format_parts:
                            if line.strip().startswith(part):
                                line = line.strip()

                                if part.endswith('"'):
                                    key = part.rstrip(' :"')
                                    value = line.lstrip(part).rstrip('", ')
                                else:
                                    key = part.rstrip(" :'")
                                    value = line.lstrip(part).rstrip("', ")

                                long_date_format[key] = value

                        if long_date_format:
                            locales[file.replace(".js", "")] = long_date_format

with io.open(
    os.path.join(moment_locale_directory, "extracted.js"), "w", encoding="utf-8"
) as outfile:
    outfile.write("export const locales = " + json.dumps(locales, ensure_ascii=False, sort_keys=True, indent=4))
