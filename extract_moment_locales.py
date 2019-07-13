import codecs
import re
from json import dumps
from os import walk
from os.path import dirname, isdir, join, abspath

ESCAPE_SEQUENCE_RE = re.compile(
    r"""
    ( \\U........      # 8-digit hex escapes
    | \\u....          # 4-digit hex escapes
    | \\x..            # 2-digit hex escapes
    | \\[0-7]{1,3}     # Octal escapes
    | \\N\{[^}]+\}     # Unicode characters by name
    | \\[\\'"abfnrtv]  # Single-character escapes
    )""",
    re.UNICODE | re.VERBOSE,
)


def decode_escapes(s):
    def decode_match(match):
        return codecs.decode(match.group(0), "unicode-escape")

    return ESCAPE_SEQUENCE_RE.sub(decode_match, s)


moment_locale_directory = join(
    dirname(abspath(__file__)),
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

if isdir(moment_locale_directory):
    for root, dirs, files in walk(moment_locale_directory):
        for file in files:
            if file.endswith(".js"):
                with open(join(root, file), "r", encoding="utf-8") as locale:
                    long_date_format = {}
                    for line in locale.readlines():
                        line = " ".join(line.split()).strip()
                        for pattern in long_date_format_patterns:
                            matches = pattern.match(line)
                            if matches:
                                try:
                                    key = matches.group(1)
                                    value = decode_escapes(matches.group(4))
                                    long_date_format[key] = value
                                except IndexError:
                                    pass

                        if long_date_format:
                            locale_name = file.replace(".js", "")
                            locales[locale_name] = long_date_format
                            if locale_name == "en-gb":
                                locales["en"] = long_date_format

with open(join(moment_locale_directory, "extracted.js"), "w", encoding="utf-8") as outfile:
    outfile.write("export const locales = " + dumps(locales, ensure_ascii=False, sort_keys=True, indent=4))
