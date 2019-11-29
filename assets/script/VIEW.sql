USE [CSF_LESIONES]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE SCHEMA [view]
GO

CREATE VIEW [view].[juego]
AS
    SELECT 
    a.competitionFifaId AS COMPETICION_ID,
    a.superiorCompetitionFifaId AS COMPETICION_PADRE_ID,
    a.status AS COMPETICION_ESTADO,
    a.season AS COMPETICION_ANHO,
    b.matchFifaId AS JUEGO_CODIGO,
    b.matchDayDesc AS JUEGO_NOMBRE,
    b.status AS JUEGO_ESTADO,
    b.dateTimeLocal AS JUEGO_HORARIO,
    d1.teamFifaId AS EQUIPO_LOCAL_CODIGO,
    d1.internationalName AS EQUIPO_LOCAL_NOMBRE,
    e1.homeScore AS EQUIPO_LOCAL_RESULTADO_PRIMER,
    e2.homeScore AS EQUIPO_LOCAL_RESULTADO_SEGUNDO,
    d2.teamFifaId AS EQUIPO_VISITANTE_CODIGO,
    d2.internationalName AS EQUIPO_VISITANTE_NOMBRE,
    e1.awayScore AS EQUIPO_VISITANTE_RESULTADO_PRIMER,
    e2.awayScore AS EQUIPO_VISITANTE_RESULTADO_SEGUNDO

    FROM [comet].[competitions] a
    LEFT JOIN [comet].[matches] b ON a.competitionFifaId = b.competitionFifaId
    LEFT JOIN [comet].[matches_teams] c1 ON b.matchFifaId = c1.matchFifaId AND c1.teamNature = 'HOME'
    LEFT JOIN [comet].[teams] d1 ON c1.teamFifaId = d1.teamFifaId
    LEFT JOIN [comet].[matches_teams] c2 ON b.matchFifaId = c2.matchFifaId AND c2.teamNature = 'AWAY'
    LEFT JOIN [comet].[teams] d2 ON c2.teamFifaId = d2.teamFifaId
    LEFT JOIN [comet].[matches_phases] e1 ON b.matchFifaId = e1.matchFifaId AND e1.phase = 'FIRST_HALF'
    LEFT JOIN [comet].[matches_phases] e2 ON b.matchFifaId = e2.matchFifaId AND e2.phase = 'SECOND_HALF'

    WHERE d1.teamFifaId IS NOT NULL AND d2.teamFifaId IS NOT NULL
GO