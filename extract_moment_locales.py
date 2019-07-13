#!/usr/bin/env python
import io
import json
import os
import re

moment_locale_directory = os.path.join(
    os.path.dirname(os.path.abspath(__file__)),
    "node_modules",
    "moment",
    "src",
    "locale",
)

long_date_format_patterns = (
    re.compile(r"^(LT)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
    re.compile(r"^(LTS)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
    re.compile(r"^(L)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
    re.compile(r"^(LL)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
    re.compile(r"^(LLL)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
    re.compile(r"^(LLLL)(\s+)?:(\s+)?['\"](.*?)['\"]", re.UNICODE),
)

locales = {}

if os.path.isdir(moment_locale_directory):
    for root, dirs, files in os.walk(moment_locale_directory):
        for file in files:
            if file.endswith(".js"):
                with io.open(os.path.join(root, file), "r", encoding="utf-8") as locale:
                    long_date_format = {}
                    for line in locale.readlines():
                        line = " ".join(line.split()).strip()
                        for pattern in long_date_format_patterns:
                            matches = pattern.match(line)
                            if matches:
                                try:
                                    key = matches.group(1)
                                    value = matches.group(4)
                                    if key and value:
                                        long_date_format[key] = value
                                except IndexError:
                                    pass

                        if long_date_format:
                            locale_name = file.replace(".js", "")
                            locales[locale_name] = long_date_format
                            if locale_name == "en-gb":
                                locales["en"] = long_date_format

with io.open(
        os.path.join(moment_locale_directory, "extracted.js"), "w", encoding="utf-8"
) as outfile:
    outfile.write(
        "export const locales = "
        + json.dumps(locales, ensure_ascii=False, sort_keys=True, indent=4)
    )
